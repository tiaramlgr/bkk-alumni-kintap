@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Lowongan Kerja Tersedia</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($lowongans as $lowongan)
        <div class="bg-white border rounded-3xl overflow-hidden hover:shadow-lg transition">
            <div class="p-6">
                <h3 class="font-semibold text-lg mb-2">{{ $lowongan->judul_lowongan }}</h3>
                <p class="text-gray-600">{{ $lowongan->nama_perusahaan }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $lowongan->lokasi }}</p>
                
                <div class="mt-4 text-sm">
                    <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        {{ $lowongan->tipe_pekerjaan }}
                    </span>
                </div>
            </div>
            <div class="border-t p-6 flex justify-between items-center">
                <span class="text-sm text-gray-500">Deadline: {{ $lowongan->deadline }}</span>
                <a href="{{ route('alumni.lowongan.show', $lowongan->id) }}" 
                   class="bg-blue-600 text-white px-5 py-2.5 rounded-2xl text-sm hover:bg-blue-700">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection