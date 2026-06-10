@extends('layouts.admin')

@section('title', 'Manajemen Lowongan Kerja')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Lowongan Kerja</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola publikasi info lowongan kerja dari mitra & sekolah</p>
    </div>
    <a href="{{ route('admin.lowongan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold flex items-center gap-2 transition shadow-lg shadow-blue-600/20">
        <i class="fas fa-plus"></i> Tambah Lowongan
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl mb-6 font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
    <table class="w-full border-collapse">
        <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
            <tr>
                <th class="px-6 py-4 text-left">Judul Posisi</th>
                <th class="px-6 py-4 text-left">Perusahaan</th>
                <th class="px-6 py-4 text-center">Batas Waktu</th>
                <th class="px-6 py-4 text-center">Kandidat</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
            @forelse($lowongans as $lowongan)
            <tr class="hover:bg-slate-50/80 transition">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-900">{{ $lowongan->judul_lowongan }}</div>
                    <div class="text-xs text-slate-400 mt-0.5"><i class="fas fa-map-marker-alt mr-1"></i>{{ $lowongan->lokasi }}</div>
                </td>
                <td class="px-6 py-4 font-medium">{{ $lowongan->nama_perusahaan }}</td>
                <td class="px-6 py-4 text-center">
                    {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('admin.lowongan.pelamar', $lowongan->id) }}" class="bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white px-3 py-1 rounded-full text-xs font-bold transition">
                        Lihat Pelamar ({{ $lowongan->lamarans()->count() }})
                    </a>
                </td>
                <td class="px-6 py-4 text-center">
                    @if($lowongan->status == 'aktif')
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Aktif</span>
                    @else
                        <span class="bg-rose-50 text-rose-700 border border-rose-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Tutup</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-3">
                        <a href="{{ route('admin.lowongan.show', $lowongan->id) }}" class="text-slate-500 hover:text-blue-600 transition" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}" class="text-slate-500 hover:text-indigo-600 transition" title="Edit Data">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.lowongan.destroy', $lowongan->id) }}" method="POST" class="inline" onsubmit="return confirm('Menghapus lowongan ini juga akan menghapus data lamaran yang terkait. Yakin?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-500 hover:text-rose-600 transition" title="Hapus Data">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada iklan lowongan kerja yang dipublikasikan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection