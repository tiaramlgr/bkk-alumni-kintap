@extends('layouts.admin')

@section('title', 'Master Kategori Lowongan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Kategori Lowongan</h1>
            <p class="text-sm text-slate-500 mt-1">Klasifikasi bidang industri penempatan bursa kerja</p>
        </div>
        <a href="{{ route('admin.kategori-lowongan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold flex items-center gap-2 transition shadow-lg shadow-blue-600/20">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl font-medium">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-rose-100 border border-rose-400 text-rose-800 px-4 py-3 rounded-2xl font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left w-16">No</th>
                    <th class="px-6 py-4 text-center w-24">Ikon</th>
                    <th class="px-6 py-4 text-left">Nama Kategori</th>
                    <th class="px-6 py-4 text-center">Iklan Terikat</th>
                    <th class="px-6 py-4 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($kategoris as $kategori)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4 font-medium">{{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $loop->iteration }}</td>
                    <td class="px-6 py-4 text-center text-lg">
                        <i class="{{ $kategori->icon ?? 'fas fa-briefcase' }} text-blue-600 bg-blue-50 p-2.5 rounded-xl w-10 text-center"></i>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-900">{{ $kategori->nama_kategori }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full font-bold text-xs">
                            {{ $kategori->lowongans_count }} Iklan
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <a href="{{ route('admin.kategori-lowongan.show', $kategori->id) }}" class="text-slate-500 hover:text-blue-600 transition" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.kategori-lowongan.edit', $kategori->id) }}" class="text-slate-500 hover:text-indigo-600 transition" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.kategori-lowongan.destroy', $kategori->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada kategori lowongan kerja yang diinput.</td>
                </tr>
                @endempty
            </tbody>
        </table>
        
        @if($kategoris->hasPages())
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            {{ $kategoris->links() }}
        </div>
        @endif
    </div>
</div>
@endsection