@extends('layouts.admin')

@section('title', 'Posting Lowongan Kerja Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.lowongan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Lowongan
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-8 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-bold text-slate-900">Posting Lowongan Baru</h2>
            <p class="text-sm text-slate-500 mt-1">Publikasikan informasi bursa kerja untuk alumni SMK Negeri Kintap</p>
        </div>

        <form method="POST" action="{{ route('admin.lowongan.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Posisi Lowongan</label>
                    <input type="text" name="judul_lowongan" value="{{ old('judul_lowongan') }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Bidang</label>
                    <select name="kategori_id" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Kategori Pekerjaan --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Perusahaan/Instansi</label>
                    <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tipe Pekerjaan</label>
                    <select name="tipe_pekerjaan" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                        <option value="full_time" {{ old('tipe_pekerjaan') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('tipe_pekerjaan') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="kontrak" {{ old('tipe_pekerjaan') == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="magang" {{ old('tipe_pekerjaan') == 'magang' ? 'selected' : '' }}>Magang / Internship</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Batas Waktu (Deadline)</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Penempatan</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Kintap, Tanah Laut"
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Poster / Gambar (Opsional)</label>
                    <input type="file" name="foto" accept="image/png, image/jpeg, image/jpg" 
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi" rows="6" required placeholder="Jelaskan detail tanggung jawab pekerjaan..."
                              class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">{{ old('deskripsi') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kualifikasi & Persyaratan</label>
                    <textarea name="kualifikasi" rows="6" required placeholder="Minimal lulusan, keahlian khusus, dsb..."
                              class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">{{ old('kualifikasi') }}</textarea>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex items-center gap-3">
                <input type="checkbox" name="siaran_wa" id="siaran_wa" class="w-5 h-5 accent-blue-600 rounded">
                <label for="siaran_wa" class="text-sm font-semibold text-blue-800 cursor-pointer">
                    Kirim notifikasi otomatis via WhatsApp ke seluruh alumni aktif saat lowongan ini dipublikasikan.
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all text-lg mt-4">
                <i class="fas fa-paper-plane mr-2"></i> Publikasikan Lowongan
            </button>
        </form>
    </div>
</div>
@endsection