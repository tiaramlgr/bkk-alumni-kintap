@extends('layouts.admin')

@section('title', 'Detail Lowongan Kerja')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.lowongan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Lowongan
        </a>
        <div class="space-x-2">
            <a href="{{ route('admin.lowongan.pelamar', $lowongan->id) }}" class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-xl text-sm font-bold transition">
                <i class="fas fa-users mr-1"></i> Lihat Pelamar
            </a>
            <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-4 py-2 rounded-xl text-sm font-bold transition">
                <i class="fas fa-edit mr-1"></i> Edit Iklan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="flex flex-col md:flex-row border-b border-slate-100">
            <div class="w-full md:w-1/3 bg-slate-50 flex items-center justify-center p-6 border-b md:border-b-0 md:border-r border-slate-100">
                @if($lowongan->foto)
                    <img src="{{ Storage::url($lowongan->foto) }}" alt="Poster Lowongan" class="max-h-64 object-contain rounded-xl shadow-sm">
                @else
                    <div class="text-center text-slate-400">
                        <i class="fas fa-image text-5xl mb-2"></i>
                        <p class="text-xs font-semibold">Tidak ada poster</p>
                    </div>
                @endif
            </div>
            
            <div class="w-full md:w-2/3 p-8 flex flex-col justify-center">
                <div class="mb-4">
                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 inline-block">
                        {{ $lowongan->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                    <h2 class="text-3xl font-black text-slate-900">{{ $lowongan->judul_lowongan }}</h2>
                    <p class="text-lg font-medium text-slate-600 mt-1">{{ $lowongan->nama_perusahaan }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <span class="text-slate-400 block text-xs font-bold uppercase">Lokasi</span>
                        <span class="font-semibold text-slate-800"><i class="fas fa-map-marker-alt text-rose-500 mr-1"></i> {{ $lowongan->lokasi }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs font-bold uppercase">Tipe Pekerjaan</span>
                        <span class="font-semibold text-slate-800"><i class="fas fa-briefcase text-amber-500 mr-1"></i> {{ ucwords(str_replace('_', ' ', $lowongan->tipe_pekerjaan)) }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs font-bold uppercase">Batas Lamaran</span>
                        <span class="font-semibold text-rose-600"><i class="fas fa-calendar-times mr-1"></i> {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs font-bold uppercase">Status</span>
                        @if($lowongan->status == 'aktif')
                            <span class="text-emerald-600 font-bold"><i class="fas fa-check-circle mr-1"></i> Sedang Aktif</span>
                        @else
                            <span class="text-slate-500 font-bold"><i class="fas fa-times-circle mr-1"></i> Sudah Ditutup</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-50">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 text-lg border-b pb-3 mb-4 flex items-center gap-2">
                    <i class="fas fa-align-left text-blue-500"></i> Deskripsi Pekerjaan
                </h3>
                <div class="prose prose-sm text-slate-600 whitespace-pre-line">
                    {{ $lowongan->deskripsi }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 text-lg border-b pb-3 mb-4 flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-emerald-500"></i> Syarat & Kualifikasi
                </h3>
                <div class="prose prose-sm text-slate-600 whitespace-pre-line">
                    {{ $lowongan->kualifikasi }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection