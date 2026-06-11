@extends('layouts.admin')

@section('title', 'Detail Dokumen Alumni')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.dokumen.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Dokumen
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 bg-slate-50 flex justify-between items-start">
            <div>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 inline-block">
                    {{ $dokumen->tipe_dokumen }}
                </span>
                <h2 class="text-2xl font-bold text-slate-900">{{ $dokumen->alumni->user->name ?? 'User Tidak Ditemukan' }}</h2>
                <p class="text-slate-500 font-medium mt-1">NISN: <span class="text-slate-700 font-mono">{{ $dokumen->alumni->nisn ?? '-' }}</span></p>
            </div>
            <div>
                <a href="{{ route('admin.dokumen.edit', $dokumen->id) }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-4 py-2 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">
                    <i class="fas fa-edit text-indigo-500"></i> Edit
                </a>
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
            <div class="space-y-5">
                <h3 class="font-bold text-slate-800 text-base border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-file-alt text-blue-500"></i> Rincian File
                </h3>
                <div>
                    <span class="text-slate-400 block text-xs font-bold uppercase mb-1">Nama File System</span>
                    <span class="font-semibold text-slate-900 break-words">{{ $dokumen->nama_file }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-xs font-bold uppercase mb-1">Tahun Terbit</span>
                    <span class="font-semibold text-slate-900">{{ $dokumen->tahun_dokumen }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-xs font-bold uppercase mb-1">Status Visibilitas</span>
                    @if($dokumen->is_active)
                        <span class="text-emerald-600 font-bold"><i class="fas fa-check-circle mr-1"></i> Aktif (Dapat dilihat Alumni)</span>
                    @else
                        <span class="text-rose-600 font-bold"><i class="fas fa-times-circle mr-1"></i> Tersembunyi</span>
                    @endif
                </div>
            </div>

            <div class="space-y-5">
                <h3 class="font-bold text-slate-800 text-base border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-history text-blue-500"></i> Riwayat Sistem
                </h3>
                <div>
                    <span class="text-slate-400 block text-xs font-bold uppercase mb-1">Diunggah Oleh (Admin)</span>
                    <span class="font-semibold text-slate-900">{{ $dokumen->admin->name ?? 'Sistem' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-xs font-bold uppercase mb-1">Tanggal Unggah</span>
                    <span class="font-semibold text-slate-900">{{ $dokumen->created_at->format('d F Y, H:i') }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-xs font-bold uppercase mb-1">Terakhir Diperbarui</span>
                    <span class="font-semibold text-slate-900">{{ $dokumen->updated_at->format('d F Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 p-6 border-t border-slate-100 flex justify-center">
            <a href="{{ Storage::url($dokumen->path_file) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-bold transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <i class="fas fa-external-link-alt"></i> Buka / Unduh Dokumen
            </a>
        </div>
    </div>
</div>
@endsection