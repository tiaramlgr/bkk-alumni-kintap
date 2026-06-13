@extends('layouts.admin')

@section('title', 'Detail Siaran WhatsApp')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.siaran.index') }}" class="text-slate-500 hover:text-blue-600 transition flex items-center gap-2 text-sm font-semibold mb-6">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $siaran->judul_siaran }}</h1>
                <p class="text-sm text-slate-500 mt-1">Dibuat pada: {{ $siaran->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div>
                @if($siaran->status_batch == 'selesai')
                    <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider">Selesai</span>
                @elseif($siaran->status_batch == 'proses')
                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider">Proses</span>
                @elseif($siaran->status_batch == 'gagal')
                    <span class="bg-rose-100 text-rose-700 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider">Gagal</span>
                @else
                    <span class="bg-amber-100 text-amber-700 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider">Draft</span>
                @endif
            </div>
        </div>

        <div class="p-8 space-y-8">
            <div class="grid grid-cols-2 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Status Pengiriman</span>
                    <span class="font-semibold text-slate-800">
                        {{ $siaran->dikirim_at ? \Carbon\Carbon::parse($siaran->dikirim_at)->format('d F Y, H:i') : 'Belum dikirim' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Jumlah Pengiriman</span>
                    <span class="font-semibold text-slate-800">{{ $siaran->total_penerima }} Target Grup</span>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-700 mb-3 uppercase tracking-wider border-b pb-2">Isi Pesan (Template)</h3>
                <div class="bg-green-50 text-green-900 p-6 rounded-2xl whitespace-pre-wrap font-mono text-sm border border-green-200">
{{ $siaran->template_pesan }}
                </div>
            </div>

            @if($siaran->meta)
            <div>
                <h3 class="text-sm font-bold text-slate-700 mb-3 uppercase tracking-wider border-b pb-2">Log Sistem (Meta)</h3>
                <div class="bg-slate-800 text-slate-300 p-6 rounded-2xl whitespace-pre-wrap font-mono text-xs overflow-x-auto">
{{ json_encode(json_decode($siaran->meta), JSON_PRETTY_PRINT) }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection