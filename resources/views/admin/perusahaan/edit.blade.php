@extends('layouts.admin')

@section('title', 'Edit Perusahaan')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.perusahaan.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600 transition mb-6 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Edit Data Perusahaan</h2>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
                <ul class="list-disc pl-5 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.perusahaan.update', $perusahaan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Sektor Industri <span class="text-red-500">*</span></label>
                    <input type="text" name="sektor_industri" value="{{ old('sektor_industri', $perusahaan->sektor_industri) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">No. Telepon / HRD</label>
                    <input type="text" name="no_hp_wa" value="{{ old('no_hp_wa', $perusahaan->no_hp_wa) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Email Perusahaan</label>
                    <input type="email" name="email_kantor" value="{{ old('email_kantor', $perusahaan->email_kantor) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">                
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg transition mt-4">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection