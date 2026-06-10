@extends('layouts.perusahaan')

@section('title', 'Data Pelamar')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Data Pelamar</h1>

    <div class="bg-white rounded-3xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Nama Pelamar</th>
                    <th class="px-6 py-4 text-left">Lowongan</th>
                    <th class="px-6 py-4 text-left">Tanggal Lamar</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lamarans as $lamaran)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $lamaran->alumni->user->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $lamaran->lowongan->judul_lowongan ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $lamaran->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($lamaran->status_lamaran == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-sm">Menunggu</span>
                        @elseif($lamaran->status_lamaran == 'diterima')
                            <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm">Diterima</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('perusahaan.lamaran.show', $lamaran->id) }}" 
                           class="text-emerald-600 hover:underline font-medium">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-gray-500">Belum ada pelamar untuk lowongan Anda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection