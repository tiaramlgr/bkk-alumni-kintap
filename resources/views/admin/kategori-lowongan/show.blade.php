@extends('layouts.admin')

@section('title', 'Detail Kategori Lowongan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('admin.kategori-lowongan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Kategori Lowongan
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden flex flex-col md:flex-row">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-10 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-blue-200 min-w-[250px]">
            <div class="w-24 h-24 bg-white rounded-full shadow-md flex items-center justify-center mb-4">
                <i class="{{ $kategori->icon ?? 'fas fa-briefcase' }} text-4xl text-blue-600"></i>
            </div>
            <code class="text-xs text-blue-800 bg-blue-200/50 px-3 py-1 rounded-lg font-mono">{{ $kategori->icon ?? 'fas fa-briefcase' }}</code>
        </div>

        <div class="p-8 flex-1">
            <div class="mb-6">
                <h2 class="text-2xl font-black text-slate-800">{{ $kategori->nama_kategori }}</h2>
                <p class="text-sm text-slate-500 mt-1">Master Data Klasterisasi Bidang Pekerjaan</p>
            </div>

            <div class="space-y-4 text-sm">
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex justify-between items-center">
                    <span class="text-slate-600 font-medium">Total Iklan Lowongan Terikat</span>
                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full font-bold text-xs">{{ $kategori->lowongans_count }} Lowongan</span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div><span class="text-slate-400 text-xs block uppercase tracking-wider font-bold">Dibuat Pada</span><span class="font-semibold text-slate-800">{{ $kategori->created_at->format('d M Y') }}</span></div>
                    <div><span class="text-slate-400 text-xs block uppercase tracking-wider font-bold">Diperbarui Pada</span><span class="font-semibold text-slate-800">{{ $kategori->updated_at->format('d M Y') }}</span></div>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.kategori-lowongan.edit', $kategori->id) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit Kategori Ini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection