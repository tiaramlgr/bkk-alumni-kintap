@extends('layouts.perusahaan')

@section('title', 'Posting Lowongan Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Posting Lowongan Kerja Baru</h1>

    <form method="POST" action="{{ route('perusahaan.lowongan.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow p-8">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Judul Lowongan</label>
                <input type="text" name="judul_lowongan" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Lokasi</label>
                <input type="text" name="lokasi" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Tipe Pekerjaan</label>
                <select name="tipe_pekerjaan" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="magang">Magang</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Kategori</label>
                <select name="kategori_id" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                    <option value="">Pilih Kategori</option>
                    @foreach(\App\Models\KategoriLowongan::all() as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Deskripsi Pekerjaan</label>
                <textarea name="deskripsi" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl"></textarea>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Kualifikasi</label>
                <textarea name="kualifikasi" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Deadline</label>
                <input type="date" name="deadline" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
            </div>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium mb-2">Poster / Banner Lowongan (Opsional)</label>
            <input type="file" name="foto" accept="image/png, image/jpeg, image/jpg" 
                class="w-full px-4 py-3 border border-gray-300 rounded-2xl bg-slate-50 cursor-pointer">
            <p class="text-xs text-slate-500 mt-2">*Format file: JPG, JPEG, PNG. Maksimal 2MB.</p>
        </div>
        
        <button type="submit" class="mt-10 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold text-lg">
            POSTING LOWONGAN
        </button>
    </form>
</div>
@endsection