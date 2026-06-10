@extends('layouts.admin')

@section('title', 'Edit Data Alumni')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('admin.alumni.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Kelola Alumni
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Edit Data Alumni</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi akun dan verifikasi kelulusan</p>
        </div>

        <form method="POST" action="{{ route('admin.alumni.update', $alumni->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $alumni->user->name) }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                    @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $alumni->user->email) }}" required 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                    @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP/WhatsApp</label>
                    <input type="text" name="no_hp_wa" value="{{ old('no_hp_wa', $alumni->no_hp_wa) }}" 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                    @error('no_hp_wa') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Verifikasi Akun</label>
                    <select name="status_akun" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500">
                        <option value="pending" {{ $alumni->status_akun == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                        <option value="approved" {{ $alumni->status_akun == 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                        <option value="rejected" {{ $alumni->status_akun == 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Verifikasi (Jika Ditolak)</label>
                <textarea name="catatan_verifikasi" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:border-blue-500" placeholder="Misal: Nomor ijazah tidak sesuai dengan database sekolah.">{{ old('catatan_verifikasi', $alumni->catatan_verifikasi) }}</textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection