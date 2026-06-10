@extends('layouts.admin')

@section('title', 'Edit Lowongan Kerja')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.lowongan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Lowongan
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-8 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-bold text-slate-900">Edit Lowongan Kerja</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui rincian dan persyaratan dari iklan lowongan yang sudah tayang</p>
        </div>

        <form method="POST" action="{{ route('admin.lowongan.update', $lowongan->id) }}" enctype="multipart/form-data" class="space-y-6">
        <form method="POST" action="{{ route('admin.lowongan.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Posisi Lowongan</label>
                    <input type="text" name="judul_lowongan" value="{{ old('judul_lowongan', $lowongan->judul_lowongan) }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Bidang</label>
                    <select name="kategori_id" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ (old('kategori_id', $lowongan->kategori_id) == $kat->id) ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Perusahaan/Instansi</label>
                    <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $lowongan->nama_perusahaan) }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tipe Pekerjaan</label>
                    <select name="tipe_pekerjaan" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                        <option value="full_time" {{ $lowongan->tipe_pekerjaan == 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ $lowongan->tipe_pekerjaan == 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="kontrak" {{ $lowongan->tipe_pekerjaan == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="magang" {{ $lowongan->tipe_pekerjaan == 'magang' ? 'selected' : '' }}>Magang / Internship</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Batas Waktu (Deadline)</label>
                    <input type="date" name="deadline" value="{{ old('deadline', \Carbon\Carbon::parse($lowongan->deadline)->format('Y-m-d')) }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Penempatan</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Poster (Abaikan jika tidak diubah)</label>
                    <input type="file" name="foto" accept="image/png, image/jpeg, image/jpg" 
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi" rows="6" required 
                              class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kualifikasi & Persyaratan</label>
                    <textarea name="kualifikasi" rows="6" required 
                              class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-600/20 transition-all text-lg mt-4">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection