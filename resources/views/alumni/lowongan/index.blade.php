@extends('layouts.alumni')

@section('title', 'Lowongan Kerja')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Lowongan Kerja Tersedia</h1>
        <span class="text-sm text-gray-500">{{ $lowongans->total() }} lowongan aktif</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lowongans as $lowongan)
        <div class="bg-white rounded-3xl shadow hover:shadow-xl transition-all p-6">
            @if($lowongan->foto)
                <img src="{{ asset('storage/' . $lowongan->foto) }}" 
                     class="w-full h-48 object-cover rounded-2xl mb-4" alt="Foto Lowongan">
            @endif

            <h3 class="font-semibold text-lg line-clamp-2 mb-2">{{ $lowongan->judul_lowongan }}</h3>
            <p class="text-gray-700 font-medium">{{ $lowongan->nama_perusahaan }}</p>
            <p class="text-sm text-gray-500">{{ $lowongan->lokasi }} • {{ $lowongan->tipe_pekerjaan }}</p>

            <div class="mt-6 flex justify-between items-center">
                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                    {{ $lowongan->kategori->nama_kategori ?? 'Umum' }}
                </span>
                <a href="{{ route('alumni.lowongan.show', $lowongan->id) }}" 
                   class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                    Lihat Detail →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-3xl p-12 text-center">
            <p class="text-gray-500">Belum ada lowongan kerja aktif saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection