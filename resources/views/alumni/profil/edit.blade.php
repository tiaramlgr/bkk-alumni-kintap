@extends('layouts.alumni')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-slate-800">Edit Profil Saya</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-2xl shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-bold">
                <i class="fas fa-exclamation-circle"></i> Terdapat Kesalahan:
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-2xl shadow-sm font-medium flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-lg"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-2xl shadow-sm font-medium flex items-center gap-2">
            <i class="fas fa-check-circle text-lg"></i> {{ session('success') }}
        </div>
    @endif
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('alumni.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-semibold text-blue-800 border-b border-blue-100 pb-2 mb-6">Data Akun & Identitas Utama</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Sesuai Ijazah</label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-100 text-slate-500 cursor-not-allowed">
                    <p class="text-xs text-slate-400 mt-1">*Nama akun tidak dapat diubah secara mandiri.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-100 text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NISN (Nomor Induk Siswa Nasional)</label>
                    <input type="text" value="{{ $alumni->nisn ?? '-' }}" disabled 
                           class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-100 text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $alumni->nik ?? '') }}" required placeholder="Masukkan 16 digit NIK"
                           class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $alumni->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $alumni->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $alumni->tempat_lahir ?? '') }}" required placeholder="Contoh: Tanah Laut"
                           class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $alumni->tanggal_lahir ?? '') }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <h3 class="text-lg font-semibold text-blue-800 border-b border-blue-100 pb-2 mb-6 mt-8">Data Akademik & Kontak</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jurusan / Program Keahlian <span class="text-red-500">*</span></label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $alumni->jurusan ?? '') }}" required placeholder="Contoh: Teknik Komputer dan Jaringan"
                           class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Lulus <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $alumni->tahun_lulus) }}" required placeholder="Contoh: 2024"
                           class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No HP / WhatsApp Aktif <span class="text-red-500">*</span></label>
                    <input type="text" name="no_hp_wa" value="{{ old('no_hp_wa', $alumni->no_hp_wa) }}" required placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap Saat Ini <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" required placeholder="Tuliskan alamat domisili Anda secara lengkap..."
                              class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('alamat', $alumni->alamat) }}</textarea>
                </div>

                <div class="col-span-1 md:col-span-2 mt-4 bg-emerald-50 border border-emerald-100 p-5 rounded-2xl">
                    <label class="flex items-start md:items-center gap-4 cursor-pointer group">
                        <div class="mt-1 md:mt-0">
                            <input type="checkbox" name="is_subscribe_wa" value="1"
                                   {{ $alumni->is_subscribe_wa ? 'checked' : '' }} 
                                   class="w-6 h-6 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500 cursor-pointer">
                        </div>
                        <div>
                            <span class="block font-bold text-emerald-800 group-hover:text-emerald-600 transition">Berlangganan Informasi Loker via WhatsApp</span>
                            <span class="text-sm text-emerald-600/80">Centang kotak ini jika Anda ingin menerima pesan otomatis saat ada lowongan kerja baru.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-lg transition shadow-lg shadow-blue-500/30 flex items-center justify-center gap-3 transform hover:-translate-y-1">
                    <i class="fas fa-save text-xl"></i> Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection