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
    /**
     * Base URL WhatsApp Gateway (Fonnte / WA-Gateway / dll).
     * Set via .env: WA_GATEWAY_URL, WA_GATEWAY_TOKEN
     */
    private string $gatewayUrl;
    private string $gatewayToken;

    public function __construct()
    {
        $this->gatewayUrl   = rtrim(config('services.whatsapp.url', env('WA_GATEWAY_URL', '')), '/');
        $this->gatewayToken = config('services.whatsapp.token', env('WA_GATEWAY_TOKEN', ''));
    }

    /* ------------------------------------------------------------------ */
    /*  INDEX                                                               */
    /* ------------------------------------------------------------------ */
    public function index()
    {
        $siarans = SiaranWa::with('admin')->latest()->paginate(10);
        return view('admin.siaran.index', compact('siarans'));
    }

    /* ------------------------------------------------------------------ */
    /*  CREATE                                                              */
    /* ------------------------------------------------------------------ */
    public function create()
    {
        $totalSubscriber = Alumni::where('status_akun', 'approved')
                                  ->where('is_subscribe_wa', true)
                                  ->count();
        return view('admin.siaran.create', compact('totalSubscriber'));
    }

    /* ------------------------------------------------------------------ */
    /*  STORE (draft saja, belum kirim)                                    */
    /* ------------------------------------------------------------------ */
    public function store(Request $request)
    {
        $request->validate([
            'judul_siaran'    => 'required|string|max:255',
            'template_pesan'  => 'required|string',
        ]);

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

        return redirect()->route('admin.siaran.show', $siaran->id)
                         ->with('success', 'Siaran berhasil dibuat sebagai draft. Klik "Kirim Sekarang" untuk mengirim.');
    }

    /* ------------------------------------------------------------------ */
    /*  SHOW                                                                */
    /* ------------------------------------------------------------------ */
    public function show($id)
    {
        $siaran = SiaranWa::with('admin')->findOrFail($id);
        return view('admin.siaran.show', compact('siaran'));
    }

    /* ------------------------------------------------------------------ */
    /*  EDIT                                                                */
    /* ------------------------------------------------------------------ */
    public function edit($id)
    {
        $siaran = SiaranWa::findOrFail($id);

        if ($siaran->status_batch !== 'draft') {
            return redirect()->route('admin.siaran.index')
                             ->with('error', 'Siaran yang sudah dikirim tidak dapat diedit.');
        }

        return view('admin.siaran.edit', compact('siaran'));
    }

    /* ------------------------------------------------------------------ */
    /*  UPDATE                                                              */
    /* ------------------------------------------------------------------ */
    public function update(Request $request, $id)
    {
        $siaran = SiaranWa::findOrFail($id);

        if ($siaran->status_batch !== 'draft') {
            return redirect()->route('admin.siaran.index')
                             ->with('error', 'Siaran yang sudah dikirim tidak dapat diedit.');
        }

        $request->validate([
            'judul_siaran'   => 'required|string|max:255',
            'template_pesan' => 'required|string',
        ]);

        $penerima = Alumni::where('status_akun', 'approved')
                          ->where('is_subscribe_wa', true)
                          ->count();

        $siaran->update([
            'judul_siaran'   => $request->judul_siaran,
            'template_pesan' => $request->template_pesan,
            'total_penerima' => $penerima,
        ]);

        return redirect()->route('admin.siaran.show', $siaran->id)
                         ->with('success', 'Siaran berhasil diperbarui!');
    }

    /* ------------------------------------------------------------------ */
    /*  DESTROY                                                             */
    /* ------------------------------------------------------------------ */
    public function destroy($id)
    {
        $siaran = SiaranWa::findOrFail($id);
        $siaran->delete();

        return redirect()->route('admin.siaran.index')
                         ->with('success', 'Siaran berhasil dihapus!');
    }

    /* ------------------------------------------------------------------ */
    /*  SEND — kirim ke WhatsApp Gateway                                   */
    /* ------------------------------------------------------------------ */
    public function send($id)
    {
        $siaran = SiaranWa::findOrFail($id);

        if ($siaran->status_batch === 'selesai') {
            return redirect()->route('admin.siaran.index')
                             ->with('error', 'Siaran ini sudah pernah dikirim.');
        }

        // Ambil alumni yang subscribe WA dan sudah approved
        $alumnis = Alumni::with('user')
                         ->where('status_akun', 'approved')
                         ->where('is_subscribe_wa', true)
                         ->whereNotNull('no_hp_wa')
                         ->get();

        if ($alumnis->isEmpty()) {
            return redirect()->back()
                             ->with('error', 'Tidak ada alumni subscriber WhatsApp yang aktif.');
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
                'errors'   => array_slice($errors, 0, 10), // simpan max 10 error
            ]),
        ]);

        $msg = "Siaran berhasil dikirim ke {$berhasil} alumni.";
        if ($gagal > 0) {
            $msg .= " {$gagal} gagal dikirim.";
        }

        return redirect()->route('admin.siaran.index')->with('success', $msg);
    }

    /* ------------------------------------------------------------------ */
    /*  PRIVATE HELPERS                                                     */
    /* ------------------------------------------------------------------ */

    /**
     * Format nomor HP ke format internasional (62xxx).
     */
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

    /**
     * Ganti placeholder di template pesan dengan data alumni.
     * Placeholder: {nama}, {nisn}, {jurusan}, {tahun_lulus}
     */
    private function renderPesan(string $template, Alumni $alumni): string
    {
        return str_replace(
            ['{nama}', '{nisn}', '{jurusan}', '{tahun_lulus}'],
            [
                $alumni->user->name ?? '-',
                $alumni->nisn ?? '-',
                $alumni->jurusan->nama_jurusan ?? '-',
                $alumni->tahun_lulus ?? '-',
            ],
            $template
        );
    }

    /**
     * Kirim pesan ke WhatsApp Gateway (Fonnte).
     * Fonnte API: POST https://api.fonnte.com/send
     * Header: Authorization: <token>
     * Body: target, message, countryCode
     *
     * Ganti implementasi ini sesuai provider gateway Anda.
     */
    private function kirimWa(string $nomor, string $pesan): array
    {
        if (empty($this->gatewayUrl) || empty($this->gatewayToken)) {
            // Fallback: log saja kalau belum dikonfigurasi
            Log::info('WA Gateway belum dikonfigurasi. Simulasi kirim ke: ' . $nomor);
            return ['success' => true, 'message' => 'Simulasi (gateway belum dikonfigurasi)'];
        }

        try {
            // ---- Fonnte ----
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

            // ---- Generic JSON Gateway (WA-Gateway / whacenter / dll) ----
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