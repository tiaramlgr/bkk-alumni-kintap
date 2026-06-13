@extends('layouts.perusahaan')

@section('title', 'Edit Lowongan Kerja')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('perusahaan.lowongan.index') }}" class="text-slate-500 hover:text-emerald-600 transition" title="Kembali">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Edit Lowongan Kerja</h1>
    </div>

    <form method="POST" action="{{ route('perusahaan.lowongan.update', $lowongan->id) }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Judul Lowongan</label>
                <input type="text" name="judul_lowongan" value="{{ old('judul_lowongan', $lowongan->judul_lowongan) }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Tipe Pekerjaan</label>
                <select name="tipe_pekerjaan" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    <option value="full_time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                    <option value="part_time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                    <option value="magang" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'magang' ? 'selected' : '' }}>Magang</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Kategori</label>
                <select name="kategori_id" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_id', $lowongan->kategori_id) == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline', optional($lowongan->deadline)->format('Y-m-d')) }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Deskripsi Pekerjaan</label>
                <textarea name="deskripsi" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Kualifikasi</label>
                <textarea name="kualifikasi" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
            </div>

            <div class="col-span-2 bg-slate-50 border border-dashed border-slate-300 rounded-2xl p-6 mt-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Poster / Banner Lowongan (Opsional)</label>
                
                @if($lowongan->foto)
                    <div class="mb-4">
                        <p class="text-xs text-slate-500 mb-2">Poster saat ini:</p>
                        <img src="{{ asset('storage/' . $lowongan->foto) }}" alt="Poster Lowongan" class="h-40 rounded-xl object-cover shadow-sm border border-slate-200">
                    </div>
                @endif
                
                <input type="file" name="foto" accept="image/png, image/jpeg, image/jpg" 
                       class="w-full px-4 py-3 border border-white rounded-xl bg-white cursor-pointer shadow-sm">
                <p class="text-xs text-slate-500 mt-2 font-medium"><i class="fas fa-info-circle text-emerald-500"></i> Biarkan kosong jika tidak ingin mengubah poster. Format: JPG, PNG. Maksimal 2MB.</p>
            </div>
        </div>

        <button type="submit" class="mt-8 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-bold text-lg transition-all shadow-lg shadow-emerald-600/30">
            SIMPAN PERUBAHAN LOWONGAN
        </button>
    </form>
</div>
@endsection