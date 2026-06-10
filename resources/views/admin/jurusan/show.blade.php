@extends('layouts.admin')

@section('title', 'Detail Jurusan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.jurusan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Jurusan
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-start bg-slate-50">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $jurusan->nama_kompetensi }}</h2>
                <p class="text-slate-500 font-medium mt-1">Kode: <span class="bg-slate-200 text-slate-700 px-2 py-0.5 rounded text-xs font-mono">{{ $jurusan->kode_jurusan }}</span></p>
            </div>
            <div>
                @if($jurusan->is_active)
                    <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">Aktif</span>
                @else
                    <span class="bg-rose-100 text-rose-700 border border-rose-200 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">Non-Aktif</span>
                @endif
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
            <div class="space-y-4">
                <h3 class="font-bold text-slate-800 text-base border-b pb-2">Hierarki Kompetensi</h3>
                <div><span class="text-slate-500 block">Bidang Keahlian</span><span class="font-semibold text-slate-900">{{ $jurusan->nama_bidang ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">Program Keahlian</span><span class="font-semibold text-slate-900">{{ $jurusan->nama_program ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">Kompetensi Keahlian (Jurusan)</span><span class="font-semibold text-slate-900">{{ $jurusan->nama_kompetensi ?? '-' }}</span></div>
            </div>

            <div class="space-y-4">
                <h3 class="font-bold text-slate-800 text-base border-b pb-2">Informasi Sistem</h3>
                <div><span class="text-slate-500 block">Tanggal Ditambahkan</span><span class="font-semibold text-slate-900">{{ $jurusan->created_at->format('d F Y, H:i') }}</span></div>
                <div><span class="text-slate-500 block">Terakhir Diperbarui</span><span class="font-semibold text-slate-900">{{ $jurusan->updated_at->format('d F Y, H:i') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection