@extends('layouts.admin')

@section('title', 'Detail Berita')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.berita.index') }}" class="text-slate-500 hover:text-blue-600 mb-6 inline-block transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Berita
    </a>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        @if($berita->foto)
            <img src="{{ asset('storage/' . $berita->foto) }}" class="w-full h-80 object-cover" alt="{{ $berita->judul }}">
        @endif
        
        <div class="p-8">
            <div class="flex items-center gap-4 text-sm text-slate-500 mb-4">
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold uppercase">{{ $berita->status }}</span>
                <span><i class="fas fa-calendar-alt mr-2"></i> {{ $berita->created_at->format('d M Y') }}</span>
                <span><i class="fas fa-user mr-2"></i> {{ $berita->admin->name ?? 'Admin' }}</span>
            </div>
            
            <h1 class="text-3xl font-bold text-slate-900 mb-6">{{ $berita->judul }}</h1>
            
            <div class="prose max-w-none text-slate-700 leading-relaxed">
                {!! nl2br(e($berita->konten)) !!}
            </div>
        </div>
    </div>
</div>
@endsection