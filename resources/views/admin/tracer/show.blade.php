@extends('layouts.admin')

@section('title', 'Detail Tracer Study')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.tracer.index') }}" class="p-2 bg-white rounded-xl shadow-sm text-slate-500 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Detail Tracer Study</h1>
        </div>
        <a href="{{ route('admin.tracer.edit', $tracer->id) }}" class="bg-amber-500 text-white px-5 py-2 rounded-xl font-semibold hover:bg-amber-600 transition">
            <i class="fas fa-edit mr-2"></i> Edit Data
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 p-6 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-800">{{ $tracer->alumni->user->name }}</h2>
            <p class="text-slate-500">Tahun Lulus: {{ $tracer->alumni->tahun_lulus }} | NISN: {{ $tracer->alumni->nisn }}</p>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
            <div>
                <p class="text-sm text-slate-500 mb-1">Tahun Pengisian</p>
                <p class="font-semibold text-slate-800 text-lg">{{ $tracer->tahun_pengisian }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 mb-1">Status Aktivitas Utama</p>
                <p class="font-bold text-blue-600 text-lg uppercase">{{ str_replace('_', ' ', $tracer->status_aktivitas) }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 mb-1">Instansi / Kampus / Usaha</p>
                <p class="font-semibold text-slate-800">{{ $tracer->nama_instansi ?: '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 mb-1">Jabatan</p>
                <p class="font-semibold text-slate-800">{{ $tracer->jabatan ?: '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 mb-1">Kota / Negara Lokasi</p>
                <p class="font-semibold text-slate-800">{{ $tracer->kota_kerja ?: '-' }}, {{ $tracer->negara_kerja }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 mb-1">Waktu Tunggu Mendapat Kerja</p>
                <p class="font-semibold text-slate-800">{{ $tracer->masa_tunggu_bulan ? $tracer->masa_tunggu_bulan . ' Bulan' : '-' }}</p>
            </div>
            <div class="col-span-1 md:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                <p class="text-sm text-slate-500 mb-1">Keterangan Tambahan</p>
                <p class="text-slate-700 leading-relaxed">{{ $tracer->keterangan_status ?: 'Tidak ada keterangan tambahan.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection