@extends('layouts.admin')

@section('title', 'Edit Dokumen Alumni')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.dokumen.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Dokumen
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-8 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-bold text-slate-900">Edit Dokumen: {{ $dokumen->alumni->user->name }}</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi atau ganti file dokumen yang sudah diunggah.</p>
        </div>

        <form method="POST" action="{{ route('admin.dokumen.update', $dokumen->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Dokumen</label>
                    <select name="tipe_dokumen" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                        <option value="skhu" {{ (old('tipe_dokumen', $dokumen->tipe_dokumen) == 'skhu') ? 'selected' : '' }}>SKHU</option>
                        <option value="ijazah" {{ (old('tipe_dokumen', $dokumen->tipe_dokumen) == 'ijazah') ? 'selected' : '' }}>Ijazah</option>
                        <option value="transkrip" {{ (old('tipe_dokumen', $dokumen->tipe_dokumen) == 'transkrip') ? 'selected' : '' }}>Transkrip Nilai</option>
                        <option value="sertifikat" {{ (old('tipe_dokumen', $dokumen->tipe_dokumen) == 'sertifikat') ? 'selected' : '' }}>Sertifikat Kompetensi</option>
                        <option value="lainnya" {{ (old('tipe_dokumen', $dokumen->tipe_dokumen) == 'lainnya') ? 'selected' : '' }}>Dokumen Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit Dokumen</label>
                    <input type="number" name="tahun_dokumen" value="{{ old('tahun_dokumen', $dokumen->tahun_dokumen) }}" required min="2000" max="{{ date('Y') }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti File (Kosongkan jika tidak ingin mengubah file)</label>
                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center hover:bg-slate-50 transition">
                    <input type="file" name="file_dokumen" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-slate-400 mt-2">File saat ini: <a href="{{ Storage::url($dokumen->path_file) }}" target="_blank" class="text-blue-600 underline">{{ $dokumen->nama_file }}</a></p>
                </div>
            </div>

            <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ $dokumen->is_active ? 'checked' : '' }} class="w-5 h-5 accent-blue-600">
                <label class="text-sm font-medium text-slate-700 cursor-pointer">Dokumen ini aktif dan bisa dilihat oleh alumni.</label>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-600/20 transition-all text-lg mt-4">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection