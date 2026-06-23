@extends('layouts.admin')

@section('title', 'Tambah NISN ke Whitelist')

@section('content')
<div class="p-6 max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.whitelist.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-3">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Whitelist
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Tambah NISN ke Whitelist</h1>
        <p class="text-slate-500 text-sm mt-1">
            Masukkan NISN alumni SMKN Kintap yang diizinkan mendaftar ke portal.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.whitelist.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    NISN <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" required
                       maxlength="20" placeholder="Contoh: 0012345678"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition font-mono">
                <p class="text-xs text-slate-400 mt-1">Masukkan NISN sesuai arsip/data sekolah.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap (Arsip Sekolah)</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                       placeholder="Nama sesuai ijazah (opsional)"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus') }}"
                           placeholder="2024" maxlength="4"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}"
                           placeholder="Misal: TKJ"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="2" placeholder="Catatan tambahan (opsional)"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition resize-none">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-600/20">
                    <i class="fas fa-plus mr-1"></i> Tambahkan ke Whitelist
                </button>
                <a href="{{ route('admin.whitelist.index') }}"
                   class="flex-1 text-center border border-slate-200 text-slate-600 font-semibold py-3 rounded-xl hover:bg-slate-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection