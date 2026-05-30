@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Lowongan Kerja</h1>
        <a href="{{ route('admin.lowongan.create') }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-2xl hover:bg-blue-700 transition">
            + Posting Lowongan Baru
        </a>

        <a href="{{ route('admin.lowongan.create') }}" 
           class="flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-2xl font-semibold transition shadow-lg">
            <span class="text-2xl">+</span>
            Posting Lowongan Baru
        </a>
    </div>

    @if($lowongans->count() == 0)
        <p class="text-gray-500 text-center py-12">Belum ada lowongan kerja.</p>
    @else
        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">Judul</th>
                        <th class="px-6 py-4 text-left">Perusahaan</th>
                        <th class="px-6 py-4 text-left">Lokasi</th>
                        <th class="px-6 py-4 text-left">Deadline</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowongans as $lowongan)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $lowongan->judul_lowongan }}</td>
                        <td class="px-6 py-4">{{ $lowongan->nama_perusahaan }}</td>
                        <td class="px-6 py-4">{{ $lowongan->lokasi }}</td>
                        <td class="px-6 py-4">{{ $lowongan->deadline }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($lowongan->status == 'aktif')
                                <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm">Tutup</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection