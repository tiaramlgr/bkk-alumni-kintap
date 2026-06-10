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
        $siarans = SiaranWa::with('admin')->latest()->paginate(10);
        return view('admin.siaran.index', compact('siarans'));
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
            'judul_siaran'    => 'required|string|max:255',
            'template_pesan'  => 'required|string',
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
                             ->with('success', 'Siaran WhatsApp berhasil dibuat sebagai draft.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses draft siaran: ' . $e->getMessage());
        }
    }
}