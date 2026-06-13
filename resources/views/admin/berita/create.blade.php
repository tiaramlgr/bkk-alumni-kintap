@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.berita.index') }}" class="text-slate-500 hover:text-blue-600 mb-6 inline-block">← Kembali ke Data Berita</a>
    
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-2xl font-bold mb-8">Tulis Berita Baru</h2>

        @if ($errors->any())
            <div class="bg-rose-100 text-rose-700 p-4 rounded-xl mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block font-semibold mb-2">Judul Berita</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan judul berita...">
            </div>

            <div>
                <label class="block font-semibold mb-2">Konten / Isi Berita</label>
                <textarea name="konten" rows="8" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ketikkan isi berita di sini...">{{ old('konten') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-2">Status Publikasi</label>
                <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="published">Langsung Terbitkan (Published)</option>
                    {{--  <option value="draft">Simpan sebagai Draft</option> --}} 
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-2">Foto / Thumbnail (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition">Simpan Berita</button>
        </form>
    </div>
</div>
@endsection