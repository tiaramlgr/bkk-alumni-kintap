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
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-bold">Menunggu</span>

                    @elseif($lamaran->status_lamaran == 'direview' || $lamaran->status_lamaran == 'review')
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">Sedang Direview</span>
                    @elseif($lamaran->status_lamaran == 'diterima')
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-bold">Diterima</span>

                    @elseif($lamaran->status_lamaran == 'ditolak')
                        <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-sm font-bold">Ditolak</span>

                    @else
                        <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm font-bold">{{ ucfirst($lamaran->status_lamaran) }}</span>
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