<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiaranWa;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SiaranWaController extends Controller
{
    private string $gatewayUrl;
    private string $gatewayToken;

    public function __construct()
    {
        $this->gatewayUrl   = rtrim(config('services.whatsapp.url', env('WA_GATEWAY_URL', '')), '/');
        $this->gatewayToken = config('services.whatsapp.token', env('WA_GATEWAY_TOKEN', ''));
    }

    public function index()
        {
        try {
            $siarans = SiaranWa::latest()->paginate(10); 
            
            return view('admin.siaran.index', compact('siarans'));
            
        } catch (\Throwable $th) {
            dd('ERROR HALAMAN SIARAN:', $th->getMessage(), 'BARIS:', $th->getLine());
        }
    }

    public function create()
    {
        $totalSubscriber = Alumni::where('status_akun', 'approved')
                                  ->where('is_subscribe_wa', true)
                                  ->count();
        return view('admin.siaran.create', compact('totalSubscriber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_siaran'   => 'required|string|max:255',
            'template_pesan' => 'required|string',
        ]);

        try {
            $penerima = Alumni::where('status_akun', 'approved')
                              ->where('is_subscribe_wa', true)
                              ->get();

            $siaran = SiaranWa::create([
                'admin_id'       => auth()->id(),
                'judul_siaran'   => $request->judul_siaran,
                'jenis_siaran'   => 'manual',
                'template_pesan' => $request->template_pesan,
                'total_penerima' => $penerima->count(),
                'status_batch'   => 'draft',
            ]);

            return redirect()->route('admin.siaran.index')
                             ->with('success', 'Siaran berhasil dibuat sebagai draft. Klik ikon Kirim di tabel untuk menyebarkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses draft siaran: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $siaran = SiaranWa::findOrFail($id);
        return view('admin.siaran.show', compact('siaran'));
    }

    public function destroy($id)
    {
        $siaran = SiaranWa::findOrFail($id);
        $siaran->delete();

        return redirect()->route('admin.siaran.index')->with('success', 'Data siaran berhasil dihapus!');
    }

    public function send($id)
    {
        $siaran = SiaranWa::findOrFail($id);

        if ($siaran->status_batch === 'selesai') {
            return redirect()->route('admin.siaran.index')
                             ->with('error', 'Siaran ini sudah pernah dikirim.');
        }

        // Ambil alumni berserta relasi jurusan untuk merender variabel {jurusan}
        $alumnis = Alumni::with(['user', 'jurusan'])
                         ->where('status_akun', 'approved')
                         ->where('is_subscribe_wa', true)
                         ->whereNotNull('no_hp_wa')
                         ->get();

        if ($alumnis->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada alumni subscriber WhatsApp yang aktif.');
        }

        $siaran->update([
            'status_batch'   => 'proses',
            'total_penerima' => $alumnis->count(),
        ]);

        $berhasil = 0;
        $gagal    = 0;
        $errors   = [];

        foreach ($alumnis as $alumni) {
            $nomor  = $this->formatNomor($alumni->no_hp_wa);
            $pesan  = $this->renderPesan($siaran->template_pesan, $alumni);

            $result = $this->kirimWa($nomor, $pesan);

            if ($result['success']) {
                $berhasil++;
            } else {
                $gagal++;
                $errors[] = "Gagal ke {$nomor}: " . $result['message'];
                Log::warning('WA Gateway gagal', ['nomor' => $nomor, 'error' => $result['message']]);
            }
        }

        $siaran->update([
            'status_batch'   => 'selesai',
            'total_penerima' => $berhasil,
            'meta'           => json_encode([
                'berhasil' => $berhasil,
                'gagal'    => $gagal,
                'errors'   => array_slice($errors, 0, 10),
            ]),
        ]);

        $msg = "Siaran berhasil diproses! Terkirim ke {$berhasil} alumni.";
        if ($gagal > 0) {
            $msg .= " Namun, {$gagal} gagal dikirim.";
        }

        return redirect()->route('admin.siaran.index')->with('success', $msg);
    }

    /* ------------------------------------------------------------------ */
    /* PRIVATE HELPERS                                                   */
    /* ------------------------------------------------------------------ */

    private function formatNomor(string $nomor): string
    {
        $nomor = preg_replace('/\D/', '', $nomor);

        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (!str_starts_with($nomor, '62')) {
            $nomor = '62' . $nomor;
        }

        return $nomor;
    }

    private function renderPesan(string $template, Alumni $alumni): string
    {
        // BUG FIX: Menggunakan nama_kompetensi karena itu struktur tabel Anda
        return str_replace(
            ['{nama}', '{nisn}', '{jurusan}', '{tahun_lulus}'],
            [
                $alumni->user->name ?? '-',
                $alumni->nisn ?? '-',
                $alumni->jurusan->nama_kompetensi ?? '-', 
                $alumni->tahun_lulus ?? '-',
            ],
            $template
        );
    }

    private function kirimWa(string $nomor, string $pesan): array
    {
        if (empty($this->gatewayUrl) || empty($this->gatewayToken)) {
            Log::info('WA Gateway belum dikonfigurasi. Simulasi kirim ke: ' . $nomor);
            return ['success' => true, 'message' => 'Simulasi (gateway belum dikonfigurasi)'];
        }

        try {
            if (str_contains($this->gatewayUrl, 'fonnte.com')) {
                $response = Http::withHeaders([
                    'Authorization' => $this->gatewayToken,
                ])->post('https://api.fonnte.com/send', [
                    'target'      => $nomor,
                    'message'     => $pesan,
                    'countryCode' => '62',
                ]);

                $body = $response->json();
                if ($response->ok() && ($body['status'] ?? false)) {
                    return ['success' => true, 'message' => 'OK'];
                }

                return ['success' => false, 'message' => $body['reason'] ?? 'Unknown error'];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->gatewayToken,
                'Content-Type'  => 'application/json',
            ])->post($this->gatewayUrl . '/send-message', [
                'phone'   => $nomor,
                'message' => $pesan,
            ]);

            if ($response->ok()) {
                return ['success' => true, 'message' => 'OK'];
            }

            return ['success' => false, 'message' => $response->body()];

        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}