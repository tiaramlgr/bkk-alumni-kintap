@extends('layouts.admin')

@section('title', 'Buat Siaran WhatsApp')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.siaran.index') }}" class="text-slate-500 hover:text-blue-600 transition flex items-center gap-2 text-sm font-semibold mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siaran
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Buat Siaran WhatsApp Baru</h1>
        <p class="text-slate-500 mt-2">Total target penerima saat ini: <span class="font-bold text-emerald-600">{{ $totalSubscriber ?? 0 }} Alumni</span></p>
    </div>

        <form method="POST" action="{{ route('admin.siaran.store') }}" class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Judul Siaran</label>
                <input type="text" name="judul_siaran" placeholder="Contoh: Info Lowongan PT PAMA" required 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Isi Pesan WhatsApp</label>
                <textarea name="template_pesan" rows="8" placeholder="Ketik pesan WhatsApp di sini..." required 
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
                <i class="fas fa-save"></i> Simpan Draft & Lanjutkan
            </button>
        </div>
    </form>
</div>
@endsection