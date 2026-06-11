@extends('layouts.admin')

@section('title', 'Dokumen Alumni')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Distribusi Dokumen</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola dan unggah SKHU/Ijazah ke akun masing-masing alumni.</p>
        </div>
        <a href="{{ route('admin.dokumen.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold flex items-center gap-2 transition shadow-lg">
            <i class="fas fa-upload"></i> Unggah Dokumen Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <form action="{{ route('admin.dokumen.index') }}" method="GET" class="flex gap-2 w-full">
            <select name="alumni_id" class="px-4 py-2 border border-slate-200 rounded-xl w-full md:w-1/3 outline-none">
                <option value="">-- Tampilkan Semua Alumni --</option>
                @foreach($alumnis as $alumni)
                    <option value="{{ $alumni->id }}" {{ request('alumni_id') == $alumni->id ? 'selected' : '' }}>
                        {{ $alumni->user->name ?? 'Tanpa Nama' }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-900 transition">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left">Nama Alumni</th>
                    <th class="px-6 py-4 text-left">Jenis Dokumen</th>
                    <th class="px-6 py-4 text-left">Nama File</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($dokumens as $dokumen)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4 font-bold text-slate-900">{{ $dokumen->alumni->user->name ?? 'Data Terhapus' }}</td>
                    <td class="px-6 py-4 uppercase font-medium">{{ $dokumen->tipe_dokumen }}</td>
                    <td class="px-6 py-4 text-blue-600 truncate max-w-xs">
                        <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank" class="hover:underline">
                            {{ $dokumen->nama_file }}
                        </a>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        @if($dokumen->is_active)
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">Aktif</span>
                        @else
                            <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-bold">Disembunyikan</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-4">
                            <a href="{{ asset('storage/' . $dokumen->path_file) }}" download="{{ $dokumen->nama_file }}" class="text-slate-500 hover:text-emerald-600 transition" title="Unduh Dokumen">
                                <i class="fas fa-download text-lg"></i>
                            </a>
                            
                            <a href="{{ route('admin.dokumen.show', $dokumen->id) }}" class="text-slate-500 hover:text-blue-600 transition" title="Lihat Detail">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                            
                            <a href="{{ route('admin.dokumen.edit', $dokumen->id) }}" class="text-slate-500 hover:text-indigo-600 transition" title="Edit Dokumen">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            
                            <form action="{{ route('admin.dokumen.destroy', $dokumen->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-rose-600 transition" title="Hapus Dokumen">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr> @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada dokumen yang didistribusikan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            {{ $dokumens->links() }}
        </div>
    </div>
</div>
@endsection