@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <h1 class="text-3xl font-bold mb-8">Posting Lowongan Kerja Baru</h1>

    <form method="POST" action="{{ route('admin.lowongan.store') }}" class="bg-white rounded-3xl shadow p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Judul Lowongan</label>
                <input type="text" name="judul_lowongan" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-blue-500">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Foto Lowongan (Opsional)</label>
                <input type="file" name="foto" accept="image/*" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max 2MB</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Kategori</label>
                <select name="kategori_id" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
                    <option value="">Pilih Kategori</option>
                    @foreach(\App\Models\KategoriLowongan::all() as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
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
                <label class="block text-sm font-medium mb-2">Deadline</label>
                <input type="date" name="deadline" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Deskripsi Pekerjaan</label>
                <textarea name="deskripsi" rows="5" required 
                          class="w-full px-4 py-3 border border-gray-300 rounded-2xl"></textarea>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Kualifikasi</label>
                <textarea name="kualifikasi" rows="4" required 
                          class="w-full px-4 py-3 border border-gray-300 rounded-2xl"></textarea>
            </div>

            <div class="col-span-2">
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="siaran_wa" class="w-5 h-5 accent-blue-600">
                    <span class="text-gray-700">Kirim siaran WhatsApp ke seluruh alumni</span>
                </label>
            </div>
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold text-lg transition">
            Posting Lowongan Kerja
        </button>
    </form>
</div>
@endsection