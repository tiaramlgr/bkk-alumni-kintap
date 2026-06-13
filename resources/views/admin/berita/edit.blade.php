@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.berita.index') }}" class="text-slate-500 hover:text-blue-600 mb-6 inline-block transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Berita
    </a>
    
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Edit Berita</h2>
                <p class="text-slate-500 text-sm">Perbarui informasi dan konten berita BKK.</p>
            </div>
        </div>

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block font-semibold text-slate-800 mb-2">Judul Berita</label>
                <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Masukkan judul berita...">
                @error('judul')
                    <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-slate-800 mb-2">Konten / Isi Berita</label>
                <textarea name="konten" rows="8" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Ketikkan isi berita di sini...">{{ old('konten', $berita->konten) }}</textarea>
                @error('konten')
                    <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <label class="block font-semibold text-slate-800 mb-4">Foto / Thumbnail Berita</label>
                
                @if($berita->foto)
                    <div class="mb-6 flex items-start gap-4">
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $berita->foto) }}" alt="Foto Berita" class="h-32 w-48 object-cover rounded-xl border border-slate-300 shadow-sm">
                            <div class="absolute inset-0 bg-slate-900/50 rounded-xl opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="text-white text-xs font-medium">Foto Saat Ini</span>
                            </div>
                        </div>
                    </div>
                @endif

                <p class="text-sm text-amber-600 mb-3 font-medium flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah foto.
                </p>
                <input type="file" name="foto" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                @error('foto')
                    <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-sm hover:shadow-md">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection