@extends('layouts.alumni')

@section('title', 'Kuesioner Tracer Study')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Kuesioner Tracer Study</h1>
        <p class="text-slate-500 mt-2">Bantu SMK Negeri Kintap memantau perkembangan karir Anda.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('alumni.tracer.update') }}" method="POST" id="tracerForm">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Laporan <span class="text-red-500">*</span></label>
                <select name="tahun_pengisian" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                    @php $tahunSekarang = date('Y'); @endphp
                    @for ($y = $tahunSekarang; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ old('tahun_pengisian', $tracer->tahun_pengisian ?? $tahunSekarang) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-8 bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                <label class="block text-base font-bold text-slate-800 mb-3">Apa kesibukan utama Anda saat ini? <span class="text-red-500">*</span></label>
                <select name="status_aktivitas" id="status_aktivitas" required class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition font-medium text-slate-700 shadow-sm">
                    <option value="">-- Pilih Status Saat Ini --</option>
                    <option value="bekerja" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'bekerja' ? 'selected' : '' }}>Bekerja (Karyawan/Pegawai)</option>
                    <option value="wirausaha" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'wirausaha' ? 'selected' : '' }}>Wirausaha / Memiliki Usaha Sendiri</option>
                    <option value="kuliah" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'kuliah' ? 'selected' : '' }}>Melanjutkan Kuliah / Studi Lanjut</option>
                    <option value="menganggur" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'menganggur' ? 'selected' : '' }}>Sedang Mencari Pekerjaan / Menganggur</option>
                    <option value="lainnya" {{ old('status_aktivitas', $tracer->status_aktivitas) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 dynamic-group" id="group_instansi_bekerja" style="display: none;">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2" id="label_nama_instansi">Nama Perusahaan / Kampus</label>
                        <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $tracer->nama_instansi) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2" id="label_jabatan">Jabatan / Jurusan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $tracer->jabatan) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kota Tempat Bekerja/Kuliah</label>
                        <input type="text" name="kota_kerja" value="{{ old('kota_kerja', $tracer->kota_kerja) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Masa Tunggu (Bulan)</label>
                        <input type="number" name="masa_tunggu_bulan" value="{{ old('masa_tunggu_bulan', $tracer->masa_tunggu_bulan) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    
                    <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" id="group_bekerja_khusus">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kesesuaian Kerja dengan Jurusan</label>
                            <select name="keselarasan_kerja" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">-- Pilih --</option>
                                <option value="sangat_tinggi" {{ old('keselarasan_kerja', $tracer->keselarasan_kerja) == 'sangat_tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                                <option value="tinggi" {{ old('keselarasan_kerja', $tracer->keselarasan_kerja) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                <option value="sedang" {{ old('keselarasan_kerja', $tracer->keselarasan_kerja) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pendapatan vs UMP</label>
                            <select name="pendapatan_ump" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">-- Pilih --</option>
                                <option value="di_atas_ump" {{ old('pendapatan_ump', $tracer->pendapatan_ump) == 'di_atas_ump' ? 'selected' : '' }}>Di Atas UMP</option>
                                <option value="setara_ump" {{ old('pendapatan_ump', $tracer->pendapatan_ump) == 'setara_ump' ? 'selected' : '' }}>Setara UMP</option>
                                <option value="di_bawah_ump" {{ old('pendapatan_ump', $tracer->pendapatan_ump) == 'di_bawah_ump' ? 'selected' : '' }}>Di Bawah UMP</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 dynamic-group" id="group_wirausaha" style="display: none;">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk / Usaha</label>
                        <input type="text" name="nama_produk_usaha" value="{{ old('nama_produk_usaha', $tracer->nama_produk_usaha) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Bidang Usaha</label>
                        <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha', $tracer->bidang_usaha) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kota Usaha</label>
                        <input type="text" name="kota_usaha" value="{{ old('kota_usaha', $tracer->kota_usaha) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kesesuaian Usaha dengan Jurusan</label>
                        <select name="keselarasan_usaha" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">-- Pilih --</option>
                            <option value="sangat_tinggi" {{ old('keselarasan_usaha', $tracer->keselarasan_usaha) == 'sangat_tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                            <option value="tinggi" {{ old('keselarasan_usaha', $tracer->keselarasan_usaha) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan Tambahan</label>
                    <textarea name="keterangan_status" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('keterangan_status', $tracer->keterangan_status) }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Simpan Data Kuesioner
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status_aktivitas');
        const groupBekerja = document.getElementById('group_instansi_bekerja');
        const groupBekerjaKhusus = document.getElementById('group_bekerja_khusus');
        const groupWirausaha = document.getElementById('group_wirausaha');
        const lblInstansi = document.getElementById('label_nama_instansi');
        const lblJabatan = document.getElementById('label_jabatan');

        function updateFormLayout() {
            const status = statusSelect.value;
            groupBekerja.style.display = 'none';
            groupBekerjaKhusus.style.display = 'none';
            groupWirausaha.style.display = 'none';

            if (status === 'bekerja') {
                groupBekerja.style.display = 'grid';
                groupBekerjaKhusus.style.display = 'grid';
                lblInstansi.textContent = 'Nama Perusahaan';
                lblJabatan.textContent = 'Jabatan / Posisi';
            } else if (status === 'kuliah') {
                groupBekerja.style.display = 'grid';
                lblInstansi.textContent = 'Nama Kampus';
                lblJabatan.textContent = 'Program Studi / Jurusan';
            } else if (status === 'wirausaha') {
                groupWirausaha.style.display = 'grid';
            }
        }
        statusSelect.addEventListener('change', updateFormLayout);
        updateFormLayout();
    });
</script>
@endsection