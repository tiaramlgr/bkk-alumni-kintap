@extends('layouts.perusahaan')

@section('title', 'Detail Lowongan')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('perusahaan.lowongan.index') }}" class="text-slate-500 hover:text-emerald-600 transition" title="Kembali">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Detail Lowongan Kerja</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8 border-b border-slate-100">
            <div class="md:col-span-1">
                @if($lowongan->foto)
                    <img src="{{ asset('storage/' . $lowongan->foto) }}" alt="Poster" class="w-full h-auto rounded-2xl shadow-sm border border-slate-200 object-cover">
                @else
                    <div class="w-full h-48 bg-slate-100 rounded-2xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">
                        <i class="fas fa-image text-4xl mb-2"></i>
                        <span class="text-sm font-medium">Tidak ada poster</span>
                    </div>
                @endif
            </div>

            <div class="md:col-span-2 flex flex-col justify-center">
                <div class="inline-block mb-3">
                    <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full text-sm font-bold tracking-wide">
                        {{ $lowongan->status === 'aktif' ? 'Status: Aktif' : 'Status: ' . ucfirst($lowongan->status) }}
                    </span>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">{{ $lowongan->judul_lowongan }}</h2>
                <div class="flex items-center text-slate-500 mb-6 gap-4 font-medium">
                    <div class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-emerald-500"></i> {{ $lowongan->lokasi }}</div>
                    <div class="flex items-center gap-1.5"><i class="fas fa-briefcase text-emerald-500"></i> {{ ucfirst(str_replace('_', ' ', $lowongan->tipe_pekerjaan)) }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori</span>
                        <span class="font-semibold text-slate-800">{{ $lowongan->kategori->nama_kategori ?? '-' }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Batas Lamaran (Deadline)</span>
                        <span class="font-semibold text-slate-800">{{ optional($lowongan->deadline)->format('d F Y') ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 space-y-8">
            <div>
                <h3 class="text-xl font-bold text-slate-800 border-l-4 border-emerald-500 pl-3 mb-4">Deskripsi Pekerjaan</h3>
                <div class="text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $lowongan->deskripsi }}</div>
            </div>

            <div>
                <h3 class="text-xl font-bold text-slate-800 border-l-4 border-emerald-500 pl-3 mb-4">Kualifikasi Persyaratan</h3>
                <div class="text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $lowongan->kualifikasi }}</div>
            </div>
        </div>

        <div class="bg-slate-50 p-6 flex justify-end gap-3 border-t border-slate-100">
            <a href="{{ route('perusahaan.lowongan.edit', $lowongan->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-xl font-bold transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Edit Lowongan
            </a>
        </div>
    </div>
</div>
@endsection