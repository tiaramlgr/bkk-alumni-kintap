@extends('layouts.admin')

@section('title', 'Data Master Jurusan / Kompetensi Keahlian')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Kelola Jurusan</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar kompetensi keahlian aktif di SMK Negeri Kintap</p>
        </div>
        <a href="{{ route('admin.jurusan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold flex items-center gap-2 transition shadow-lg shadow-blue-600/20">
            <i class="fas fa-plus"></i> Tambah Jurusan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Kode Jurusan</th>
                    <th class="px-6 py-4 text-left">Nama Jurusan</th>
                    <th class="px-6 py-4 text-left">Kompetensi Keahlian</th>
                    <th class="px-6 py-4 text-center">Aksi</th> 
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($jurusans as $index => $jurusan)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4 font-medium">{{ $jurusans->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-slate-100 text-slate-800 font-mono px-2 py-1 rounded-md text-xs border">
                            {{ $jurusan->kode_jurusan }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $jurusan->nama_program }}</td>
                    <td class="px-6 py-4">{{ $jurusan->nama_kompetensi }}</td>

                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <a href="{{ route('admin.jurusan.show', $jurusan->id) }}" class="text-slate-500 hover:text-blue-600 transition" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.jurusan.edit', $jurusan->id) }}" class="text-slate-500 hover:text-indigo-600 transition" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.jurusan.destroy', $jurusan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini?')">
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
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada data jurusan yang ditambahkan.</td>
                </tr>
                @endempty
            </tbody>
        </table>
        
        @if($jurusans->hasPages())
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            {{ $jurusans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection