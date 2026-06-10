@extends('layouts.admin')

@section('title', 'Edit Kategori Lowongan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.kategori-lowongan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Kategori
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Edit Kategori Lowongan</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui klasterisasi kategori industri untuk bursa kerja</p>
        </div>

        <form method="POST" action="{{ route('admin.kategori-lowongan.update', $kategori->id) }}" class="space-y-6">
            @csrf
            @method('PUT') <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori Pekerjaan</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required 
                       class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500 @error('nama_kategori') border-rose-500 @enderror">
                @error('nama_kategori') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Class Icon FontAwesome (Opsional)</label>
                <div class="flex gap-4 items-center">
                    <i class="{{ $kategori->icon ?? 'fas fa-briefcase' }} text-blue-600 bg-blue-50 p-3 rounded-xl text-xl w-12 text-center"></i>
                    <input type="text" name="icon" value="{{ old('icon', $kategori->icon) }}" 
                           class="flex-1 px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500" placeholder="Contoh: fas fa-briefcase">
                </div>
                <p class="text-xs text-slate-400 mt-2">Referensi ikon dapat dicari pada situs fontawesome.com</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all">
                Simpan Perubahan Kategori
            </button>
        </form>
    </div>
</div>
@endsection 