@extends('layouts.admin')

@section('title', 'Tambah Perusahaan')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.perusahaan.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600 transition mb-6 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Form Data Perusahaan</h2>

        <form action="{{ route('admin.perusahaan.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_perusahaan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Sektor Industri <span class="text-red-500">*</span></label>
                    <input type="text" name="sektor_industri" placeholder="Contoh: Pertambangan, IT, dll" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">No. Telepon / HRD</label>
                    <input type="text" name="no_telepon" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Email Perusahaan</label>
                    <input type="email" name="email" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition"></textarea>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition mt-4">
                Simpan Data Perusahaan
            </button>
        </form>
    </div>
</div>
@endsection