<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\SiaranWa;

class WhatsAppService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('WHATSAPP_API_URL');
        $this->apiKey = env('WHATSAPP_API_KEY');
    }

    /**
     * Kirim pesan WhatsApp ke satu nomor
     */
    public function sendMessage($nomorWa, $pesan)
    {
        if (empty($this->apiUrl) || empty($this->apiKey)) {
            return false; // API belum diatur
        }

        try {
            $response = Http::post($this->apiUrl, [
                'target' => $nomorWa,
                'message' => $pesan,
                'api_key' => $this->apiKey,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Broadcast Lowongan ke semua alumni
     */
    public function broadcastLowongan($lowongan)
    {
        $alumnis = \App\Models\Alumni::where('is_subscribe_wa', true)->get();

        $siaran = SiaranWa::create([
            'admin_id' => auth()->id(),
            'judul_siaran' => 'Lowongan Kerja Baru: ' . $lowongan->judul_lowongan,
            'jenis_siaran' => 'lowongan',
            'referensi_id' => $lowongan->id,
            'referensi_type' => 'App\Models\LowonganKerja',
            'template_pesan' => "🔔 Lowongan Kerja Baru!\n\n" .
                               "Judul: " . $lowongan->judul_lowongan . "\n" .
                               "Perusahaan: " . $lowongan->nama_perusahaan . "\n" .
                               "Lokasi: " . $lowongan->lokasi . "\n\n" .
                               "Klik untuk detail: " . url('/alumni/lowongan/' . $lowongan->id),
            'total_penerima' => $alumnis->count(),
            'status_batch' => 'proses',
        ]);

        $berhasil = 0;

        foreach ($alumnis as $alumni) {
            if ($this->sendMessage($alumni->no_hp_wa, $siaran->template_pesan)) {
                $berhasil++;
            }
        }

        $siaran->update([
            'berhasil' => $berhasil,
            'gagal' => $alumnis->count() - $berhasil,
            'status_batch' => 'selesai',
            'dikirim_at' => now(),
        ]);

        return $berhasil;
    }
}