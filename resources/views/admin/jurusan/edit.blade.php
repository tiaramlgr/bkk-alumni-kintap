@extends('layouts.admin')

@section('title', 'Edit Master Jurusan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.jurusan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Jurusan
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Edit Data Jurusan</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi master data kompetensi keahlian</p>
        </div>

        <form method="POST" action="{{ route('admin.jurusan.update', $jurusan->id) }}" class="space-y-6">
            @csrf
            @method('PUT') <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Jurusan</label>
                <input type="text" name="kode_jurusan" value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required 
                       class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500 @error('kode_jurusan') border-rose-500 @enderror">
                @error('kode_jurusan') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kompetensi Keahlian</label>
                <input type="text" name="nama_kompetensi" value="{{ old('nama_kompetensi', $jurusan->nama_kompetensi) }}" required 
                       class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500 @error('nama_kompetensi') border-rose-500 @enderror">
                @error('nama_kompetensi') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Program Keahlian</label>
                <input type="text" name="nama_program" value="{{ old('nama_program', $jurusan->nama_program) }}" required 
                       class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500 @error('nama_program') border-rose-500 @enderror">
                @error('nama_program') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Bidang Keahlian</label>
                <input type="text" name="nama_bidang" value="{{ old('nama_bidang', $jurusan->nama_bidang) }}" required 
                       class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500 @error('nama_bidang') border-rose-500 @enderror">
                @error('nama_bidang') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection