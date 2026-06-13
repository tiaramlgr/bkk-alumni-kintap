@extends('layouts.perusahaan')

@section('title', 'Manajemen Iklan Lowongan Perusahaan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Lowongan Kerja Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola publikasi dan monitoring lowongan rekrutmen aktif perusahaan Anda</p>
        </div>
        <a href="{{ route('perusahaan.lowongan.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-2xl font-bold flex items-center gap-2 transition shadow-lg shadow-emerald-600/20">
            <i class="fas fa-plus"></i> + Pasang Lowongan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl text-center font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left">Judul Posisi Lowongan</th>
                    <th class="px-6 py-4 text-left">Kategori Bidang</th>
                    <th class="px-6 py-4 text-left">Lokasi Kerja</th>
                    <th class="px-6 py-4 text-center">Batas Pendaftaran</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Opsi Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($lowongans as $lowongan)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900 text-base">{{ $lowongan->judul_lowongan }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">Tipe: {{ ucfirst($lowongan->tipe_pekerjaan) }}</div>
                    </td>
                    <td class="px-6 py-4"><span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-medium">{{ $lowongan->kategori->nama_kategori ?? '-' }}</span></td>
                    <td class="px-6 py-4 font-medium"><i class="fas fa-map-marker-alt text-slate-400 mr-1"></i> {{ $lowongan->lokasi }}</td>
                    <td class="px-6 py-4 text-center font-medium text-slate-600">{{ optional($lowongan->deadline)->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $lowongan->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center space-x-3 font-semibold">
                        <a href="{{ route('perusahaan.lowongan.show', $lowongan->id) }}" class="text-blue-600 hover:text-blue-800">Lihat</a>
                        
                        <a href="{{ route('perusahaan.lowongan.edit', $lowongan->id) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                        
                        <form action="{{ route('perusahaan.lowongan.destroy', $lowongan->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus publikasi posisi pekerjaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 bg-transparent border-0 font-semibold cursor-pointer">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                        <i class="fas fa-folder-open text-4xl mb-3 text-slate-200 block"></i>
                        Perusahaan Anda belum pernah mempublikasikan iklan lowongan pekerjaan.
                    </td>
                </tr>
                @endempty
            </tbody>
        </table>
    </div>
</div>
@endsection