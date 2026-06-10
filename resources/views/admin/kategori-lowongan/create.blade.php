@extends('layouts.admin')

@section('title', 'Tambah Kategori Lowongan Kerja')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.kategori-lowongan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Kategori
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Tambah Kategori Lowongan</h2>
            <p class="text-sm text-slate-500 mt-1">Buat klasterisasi kategori industri baru untuk bursa kerja</p>
        </div>

        <form method="POST" action="{{ route('admin.kategori-lowongan.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori Pekerjaan</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required 
                       class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-emerald-500 @error('nama_kategori') border-rose-500 @enderror" placeholder="Contoh: Pertambangan, Teknologi Informasi, Otomotif">
                @error('nama_kategori') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Class Icon FontAwesome (Opsional)</label>
                <input type="text" name="icon" value="{{ old('icon', 'fas fa-briefcase') }}" 
                       class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-emerald-500" placeholder="Contoh: fas fa-network-wired, fas fa-car">
                <p class="text-xs text-slate-400 mt-1.5">Default menggunakan ikon tas kerja (*fas fa-briefcase*).</p>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-600/20 transition-all">
                Simpan Kategori Baru
            </button>
        </form>
    </div>
</div>
@endsection