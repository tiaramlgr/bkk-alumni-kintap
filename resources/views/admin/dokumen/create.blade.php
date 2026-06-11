@extends('layouts.admin')

@section('title', 'Unggah Dokumen Alumni')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.dokumen.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Dokumen
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-8 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-bold text-slate-900">Unggah Dokumen Baru</h2>
            <p class="text-sm text-slate-500 mt-1">Pilih alumni tujuan dan unggah file dokumen (SKHU/Ijazah) untuk dikirim ke portal mereka.</p>
        </div>

        <form method="POST" action="{{ route('admin.dokumen.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Pilih Nama Alumni</label>
                <select name="alumni_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    <option value="">-- Pilih Alumni Tujuan --</option>
                    @foreach($alumnis as $alumni)
                        <option value="{{ $alumni->id }}" {{ old('alumni_id') == $alumni->id ? 'selected' : '' }}>
                            {{ $alumni->user->name ?? 'Tanpa Nama' }} (NISN: {{ $alumni->nisn }})
                        </option>
                    @endforeach
                </select>
                @error('alumni_id') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Jenis Dokumen</label>
                    <select name="tipe_dokumen" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="skhu" {{ old('tipe_dokumen') == 'skhu' ? 'selected' : '' }}>SKHU</option>
                        <option value="ijazah" {{ old('tipe_dokumen') == 'ijazah' ? 'selected' : '' }}>Ijazah</option>
                        <option value="transkrip" {{ old('tipe_dokumen') == 'transkrip' ? 'selected' : '' }}>Transkrip Nilai</option>
                        <option value="sertifikat" {{ old('tipe_dokumen') == 'sertifikat' ? 'selected' : '' }}>Sertifikat Kompetensi</option>
                        <option value="lainnya" {{ old('tipe_dokumen') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('tipe_dokumen') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_dokumen" value="{{ old('tahun_dokumen', date('Y')) }}" required min="2000" max="{{ date('Y') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    @error('tahun_dokumen') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">File Dokumen</label>
                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 transition cursor-pointer relative">
                    <input type="file" name="file_dokumen" required accept=".pdf,.jpg,.jpeg,.png"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="file-upload">
                    <div class="text-slate-400 pointer-events-none">
                        <i class="fas fa-cloud-upload-alt text-4xl mb-3 text-blue-500"></i>
                        <p class="font-semibold text-slate-700">Klik atau seret file ke area ini</p>
                        <p class="text-xs mt-1">Format yang didukung: PDF, JPG, PNG (Maks 5MB)</p>
                    </div>
                </div>
                @error('file_dokumen') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all text-base mt-4 flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i> Unggah & Distribusikan ke Alumni
            </button>
        </form>
    </div>
</div>
@endsection