@extends('layouts.admin')

@section('title', 'Edit Tracer Study')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.tracer.index') }}" class="p-2 bg-white rounded-xl shadow-sm text-slate-500 hover:text-blue-600 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Edit Data Tracer Study</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.tracer.update', $tracer->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Alumni</label>
                    <input type="text" value="{{ $tracer->alumni->user->name }} (Lulusan: {{ $tracer->alumni->tahun_lulus }})" disabled class="w-full px-4 py-3 bg-slate-100 border border-slate-200 text-slate-500 rounded-xl cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Pengisian <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_pengisian" value="{{ old('tahun_pengisian', $tracer->tahun_pengisian) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Saat Ini <span class="text-red-500">*</span></label>
                    <select name="status_aktivitas" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="bekerja" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                        <option value="wirausaha" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                        <option value="kuliah" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'kuliah' ? 'selected' : '' }}>Melanjutkan Kuliah</option>
                        <option value="menganggur" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'menganggur' ? 'selected' : '' }}>Menganggur / Belum Bekerja</option>
                        <option value="lainnya" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Masa Tunggu (Bulan)</label>
                    <input type="number" name="masa_tunggu_bulan" value="{{ old('masa_tunggu_bulan', $tracer->masa_tunggu_bulan) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Instansi / Usaha / Kampus</label>
                    <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $tracer->nama_instansi) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $tracer->jabatan) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kota Tempat Bekerja/Usaha</label>
                    <input type="text" name="kota_kerja" value="{{ old('kota_kerja', $tracer->kota_kerja) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan Tambahan</label>
                    <textarea name="keterangan_status" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">{{ old('keterangan_status', $tracer->keterangan_status) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.tracer.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 font-semibold rounded-xl hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="px-6 py-3 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 transition">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>
@endsection