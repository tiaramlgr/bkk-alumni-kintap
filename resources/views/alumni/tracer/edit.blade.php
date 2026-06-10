@extends('layouts.alumni')

@section('title', 'Tracer Study')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Tracer Study Alumni</h1>

    <div class="bg-white rounded-3xl shadow p-8">
        <form action="{{ route('alumni.tracer.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-2">Status Aktivitas Saat Ini</label>
                    <select name="status_aktivitas" required class="w-full px-4 py-3 border rounded-2xl">
                        <option value="bekerja" {{ ($tracer->status_aktivitas ?? '') == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                        <option value="wirausaha" {{ ($tracer->status_aktivitas ?? '') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                        <option value="kuliah" {{ ($tracer->status_aktivitas ?? '') == 'kuliah' ? 'selected' : '' }}>Melanjutkan Kuliah</option>
                        <option value="menganggur" {{ ($tracer->status_aktivitas ?? '') == 'menganggur' ? 'selected' : '' }}>Menganggur / Belum Bekerja</option>
                        <option value="lainnya" {{ ($tracer->status_aktivitas ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Nama Instansi / Perusahaan</label>
                    <input type="text" name="nama_instansi" value="{{ $tracer->nama_instansi ?? '' }}" class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ $tracer->jabatan ?? '' }}" class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Kota</label>
                    <input type="text" name="kota_kerja" value="{{ $tracer->kota_kerja ?? '' }}" class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Masa Tunggu (Bulan)</label>
                    <input type="number" name="masa_tunggu_bulan" value="{{ $tracer->masa_tunggu_bulan ?? '' }}" class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-2">Keterangan Tambahan</label>
                    <textarea name="keterangan_status" rows="4" class="w-full px-4 py-3 border rounded-2xl">{{ $tracer->keterangan_status ?? '' }}</textarea>
                </div>
            </div>

            <button type="submit" class="mt-10 w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-semibold text-lg">
                SIMPAN DATA TRACER STUDY
            </button>
        </form>
    </div>
</div>
@endsection