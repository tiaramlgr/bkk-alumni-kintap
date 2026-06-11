<?php

namespace App\Services;

use App\Models\Alumni;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Format nomor ke standar internasional (62)
     */
    public static function formatNomor(string $nomor): string
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
     * Fungsi Inti Pengiriman ke Gateway (Fonnte / Lainnya)
     */
    public static function kirimPesan(string $nomor, string $pesan): bool
    {
        $url = rtrim(env('WA_GATEWAY_URL', ''), '/');
        $token = env('WA_GATEWAY_TOKEN', '');

        if (empty($url) || empty($token)) {
            Log::info("Simulasi WA ke {$nomor}: {$pesan}");
            return true;
        }

        try {
            if (str_contains($url, 'fonnte.com')) {
                $response = Http::withHeaders(['Authorization' => $token])
                    ->post('https://api.fonnte.com/send', [
                        'target'      => self::formatNomor($nomor),
                        'message'     => $pesan,
                        'countryCode' => '62',
                    ]);
                return $response->ok() && ($response->json()['status'] ?? false);
            }

            // Gateway umum lainnya
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json'
            ])->post($url . '/send-message', [
                'phone'   => self::formatNomor($nomor),
                'message' => $pesan,
            ]);

            return $response->ok();
        } catch (\Throwable $e) {
            Log::error("Gagal mengirim WA ke {$nomor}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Otomatisasi 1: Broadcast Lowongan Baru
     */
    public static function broadcastLowonganBaru($lowongan)
    {
        // Ambil semua alumni yang aktif dan subscribe WA
        $alumnis = Alumni::with('user')
            ->where('status_akun', 'approved')
            ->where('is_subscribe_wa', true)
            ->whereNotNull('no_hp_wa')
            ->get();

        foreach ($alumnis as $alumni) {
            $pesan = "Halo *{$alumni->user->name}*,\n\n";
            $pesan .= "📢 *LOWONGAN KERJA BARU DIMUAT!*\n\n";
            $pesan .= "📌 Perusahaan: *{$lowongan->nama_perusahaan}*\n";
            $pesan .= "💼 Posisi: _{$lowongan->posisi_pekerjaan}_\n";
            $pesan .= "📅 Batas Pendaftaran: " . date('d M Y', strtotime($lowongan->batas_pendaftaran)) . "\n\n";
            $pesan .= "Silakan login ke Portal BKK SMKN Kintap untuk melihat detail rincian dan mengirimkan lamaran Anda.\n\n";
            $pesan .= "Sistem Informasi BKK SMKN Kintap.";

            self::kirimPesan($alumni->no_hp_wa, $pesan);
        }
    }

    /**
     * Otomatisasi 2: Notifikasi Penerimaan Pelamar
     */
    public static function notifikasiPelamarDiterima($lamaran)
    {
        $alumni = Alumni::with('user')->find($lamaran->alumni_id);
        
        if ($alumni && $alumni->is_subscribe_wa && $alumni->no_hp_wa) {
            // Menggunakan operator null-safe (?->) bawaan PHP 8
            // Jika $alumni->user tidak ada, maka akan menggunakan 'Alumni' sebagai nama default
            $namaPenerima = $alumni->user?->name ?? 'Alumni';
            $pesan = "Halo *{$namaPenerima}*,\n\n";
            $pesan .= "Kami ingin mengabarkan bahwa lamaran Anda untuk posisi *{$lamaran->lowongan->posisi_pekerjaan}* di *{$lamaran->lowongan->nama_perusahaan}* telah dinyatakan *DITERIMA* oleh pihak perusahaan.\n\n";
            $pesan .= "Silakan periksa menu 'Riwayat Lamaran' di portal BKK atau tunggu instruksi selanjutnya dari tim HCGA/HRD terkait jadwal pemanggilan kerja.\n\n";
            $pesan .= "Sukses selalu untuk karier Anda!\n\n";
            $pesan .= "Sistem Informasi BKK SMKN Kintap.";

            self::kirimPesan($alumni->no_hp_wa, $pesan);
        }
    }
}