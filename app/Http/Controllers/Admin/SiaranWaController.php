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
        $siarans = SiaranWa::latest()->paginate(10);
        return view('admin.siaran.index', compact('siarans'));
    }

    public function create()
    {
        $alumnis = Alumni::with(['user', 'jurusan'])
                         ->where('status_akun', 'approved')
                         ->where('is_subscribe_wa', true)
                         ->whereNotNull('no_hp_wa')
                         ->get();
                         
        $totalSubscriber = $alumnis->count();

        return view('admin.siaran.create', compact('totalSubscriber', 'alumnis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_pengiriman' => 'required|in:group,personal_all,personal_selected',
            'alumni_ids'        => 'required_if:target_pengiriman,personal_selected|array',
            'judul_siaran'      => 'required|string|max:255',
            'template_pesan'    => 'required|string',
        ], [
            'alumni_ids.required_if' => 'Silakan pilih minimal 1 alumni dari daftar.'
        ]);

        $totalPenerima = 0;
        if ($request->target_pengiriman == 'group') {
            $totalPenerima = 1;
        } elseif ($request->target_pengiriman == 'personal_selected') {
            $totalPenerima = count($request->alumni_ids ?? []);
        } else {
            $totalPenerima = Alumni::where('status_akun', 'approved')->where('is_subscribe_wa', true)->whereNotNull('no_hp_wa')->count();
        }

        SiaranWa::create([
            'admin_id'       => auth()->id(),
            'judul_siaran'   => $request->judul_siaran,
            'jenis_siaran'   => 'lainnya',
            'referensi_id'   => null,
            'referensi_type' => null,
            'template_pesan' => $request->template_pesan,
            'total_penerima' => $totalPenerima,
            'status_batch'   => 'pending',
            'meta'           => json_encode([
                'target_pengiriman' => $request->target_pengiriman,
                'alumni_ids'        => $request->alumni_ids ?? []
            ]),
        ]);

        return redirect()->route('admin.siaran.index')
                         ->with('success', 'Draft siaran berhasil dibuat. Klik ikon Kirim untuk menyebarkan.');
    }

    public function edit($id)
    {
        $siaran = SiaranWa::findOrFail($id);

        if ($siaran->status_batch === 'selesai' || $siaran->status_batch === 'proses') {
            return redirect()->route('admin.siaran.index')->with('error', 'Siaran yang sudah diproses atau selesai tidak dapat diedit.');
        }

        $alumnis = Alumni::with(['user', 'jurusan'])
                         ->where('status_akun', 'approved')
                         ->where('is_subscribe_wa', true)
                         ->whereNotNull('no_hp_wa')
                         ->get();

        return view('admin.siaran.edit', compact('siaran', 'alumnis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'target_pengiriman' => 'required|in:group,personal_all,personal_selected',
            'alumni_ids'        => 'required_if:target_pengiriman,personal_selected|array',
            'judul_siaran'      => 'required|string|max:255',
            'template_pesan'    => 'required|string',
        ], [
            'alumni_ids.required_if' => 'Silakan pilih minimal 1 alumni dari daftar.'
        ]);

        $siaran = SiaranWa::findOrFail($id);

        if ($siaran->status_batch === 'selesai' || $siaran->status_batch === 'proses') {
            return redirect()->route('admin.siaran.index')->with('error', 'Siaran yang sudah diproses atau selesai tidak dapat diedit.');
        }

        $totalPenerima = 0;
        if ($request->target_pengiriman == 'group') {
            $totalPenerima = 1;
        } elseif ($request->target_pengiriman == 'personal_selected') {
            $totalPenerima = count($request->alumni_ids ?? []);
        } else {
            $totalPenerima = Alumni::where('status_akun', 'approved')->where('is_subscribe_wa', true)->whereNotNull('no_hp_wa')->count();
        }

        $siaran->update([
            'judul_siaran'   => $request->judul_siaran,
            'template_pesan' => $request->template_pesan,
            'total_penerima' => $totalPenerima,
            'meta'           => json_encode([
                'target_pengiriman' => $request->target_pengiriman,
                'alumni_ids'        => $request->alumni_ids ?? []
            ]),
        ]);

        return redirect()->route('admin.siaran.index')->with('success', 'Draft siaran berhasil diperbarui.');
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
            return redirect()->route('admin.siaran.index')->with('error', 'Siaran ini sudah pernah dikirim.');
        }

        $siaran->update(['status_batch' => 'proses']);

        $metaData = json_decode($siaran->meta, true) ?? [];
        $targetPengiriman = $metaData['target_pengiriman'] ?? 'group';

        // ============================================
        // LOGIKA PENGIRIMAN KE GRUP WA
        // ============================================
        if ($targetPengiriman == 'group') {
            $targetGrup = env('WA_GROUP_ALUMNI');

            if (empty($targetGrup)) {
                $siaran->update(['status_batch' => 'gagal']);
                return redirect()->back()->with('error', 'Gagal: ID Grup WhatsApp belum diatur di file .env (WA_GROUP_ALUMNI).');
            }

            $pesan = str_replace(['{nama}', '{nisn}', '{jurusan}', '{tahun_lulus}'], ['Rekan-rekan Alumni', '-', '-', '-'], $siaran->template_pesan);
            $result = $this->kirimWa($targetGrup, $pesan);

            if ($result['success']) {
                $siaran->update([
                    'status_batch'   => 'selesai',
                    'berhasil'       => 1,
                    'gagal'          => 0,
                    'dikirim_at'     => now(),
                    'meta'           => json_encode(['target_pengiriman' => 'group', 'status' => 'Berhasil terkirim ke Grup WA']),
                ]);
                return redirect()->route('admin.siaran.index')->with('success', 'Siaran berhasil dikirim ke Grup WhatsApp!');
            } else {
                $siaran->update(['status_batch' => 'gagal', 'meta' => json_encode(['target_pengiriman' => 'group', 'error' => $result['message']])]);
                return redirect()->route('admin.siaran.index')->with('error', 'Gagal mengirim ke grup WhatsApp: ' . $result['message']);
            }
        } 
        
        // ============================================
        // LOGIKA PENGIRIMAN JAPRI PERSONAL
        // ============================================
        else {
            $query = Alumni::with(['user', 'jurusan'])
                           ->where('status_akun', 'approved')
                           ->where('is_subscribe_wa', true)
                           ->whereNotNull('no_hp_wa');
            
            // Filter hanya alumni yang dipilih jika opsi "personal_selected"
            if ($targetPengiriman == 'personal_selected' && !empty($metaData['alumni_ids'])) {
                $query->whereIn('id', $metaData['alumni_ids']);
            }

            $alumnis = $query->get();

            if ($alumnis->isEmpty()) {
                $siaran->update(['status_batch' => 'gagal']);
                return redirect()->back()->with('error', 'Tidak ada alumni tujuan yang aktif / dipilih.');
            }

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
                }
            }

            $siaran->update([
                'status_batch'   => 'selesai',
                'total_penerima' => $alumnis->count(),
                'berhasil'       => $berhasil,
                'gagal'          => $gagal,
                'dikirim_at'     => now(),
                'meta'           => json_encode([
                    'target_pengiriman' => $targetPengiriman,
                    'alumni_ids'        => $metaData['alumni_ids'] ?? [],
                    'berhasil' => $berhasil,
                    'gagal'    => $gagal,
                    'errors'   => array_slice($errors, 0, 10),
                ]),
            ]);

            $msg = "Siaran Personal selesai! Terkirim ke {$berhasil} alumni.";
            if ($gagal > 0) $msg .= " Gagal dikirim ke {$gagal} kontak.";
            
            return redirect()->route('admin.siaran.index')->with('success', $msg);
        }
    }

    /* ------------------------------------------------------------------ */
    /* PRIVATE HELPERS                                                    */
    /* ------------------------------------------------------------------ */
    private function formatNomor(string $nomor): string {
        $nomor = preg_replace('/\D/', '', $nomor);
        if (str_starts_with($nomor, '0')) return '62' . substr($nomor, 1);
        if (!str_starts_with($nomor, '62')) return '62' . $nomor;
        return $nomor;
    }

    private function renderPesan(string $template, Alumni $alumni): string {
        return str_replace(
            ['{nama}', '{nisn}', '{jurusan}', '{tahun_lulus}'],
            [$alumni->user->name ?? '-', $alumni->nisn ?? '-', $alumni->jurusan->nama_kompetensi ?? '-', $alumni->tahun_lulus ?? '-'],
            $template
        );
    }

    private function kirimWa(string $nomor, string $pesan): array {
        if (empty($this->gatewayUrl) || empty($this->gatewayToken)) return ['success' => true, 'message' => 'Simulasi'];

        try {
            if (str_contains($this->gatewayUrl, 'fonnte.com')) {
                $response = Http::withHeaders(['Authorization' => $this->gatewayToken])
                                ->post('https://api.fonnte.com/send', ['target' => $nomor, 'message' => $pesan]);
                $body = $response->json();
                return ($response->ok() && ($body['status'] ?? false)) ? ['success' => true, 'message' => 'OK'] : ['success' => false, 'message' => $body['reason'] ?? 'Error'];
            }

            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $this->gatewayToken, 'Content-Type' => 'application/json'])
                            ->post($this->gatewayUrl . '/send-message', ['phone' => $nomor, 'message' => $pesan]);
            return $response->ok() ? ['success' => true, 'message' => 'OK'] : ['success' => false, 'message' => $response->body()];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}