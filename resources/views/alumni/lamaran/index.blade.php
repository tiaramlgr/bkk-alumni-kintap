@extends('layouts.alumni')

@section('title', 'Riwayat Lamaran')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Riwayat Lamaran Saya</h1>

    <div class="bg-white rounded-3xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Lowongan</th>
                    <th class="px-6 py-4 text-left">Perusahaan</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lamarans as $lamaran)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $lamaran->lowongan->judul_lowongan ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $lamaran->lowongan->nama_perusahaan ?? '-' }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center text-gray-500">Belum ada lamaran yang dikirim.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection