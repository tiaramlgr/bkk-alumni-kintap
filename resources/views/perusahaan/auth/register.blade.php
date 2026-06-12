<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mitra Perusahaan - BKK SMKN Kintap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen flex flex-row-reverse">
        
        <!-- Kolom Kanan: Form Register Perusahaan -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-12 relative z-20">
            <div class="max-w-md w-full">
                <div class="mb-6 text-center lg:text-left">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl mb-4 shadow-inner">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Registrasi Mitra</h2>
                    <p class="text-slate-500 font-medium text-sm">Daftarkan instansi/perusahaan Anda untuk mempublikasikan lowongan kerja.</p>
                </div>

                <!-- BLOK NOTIFIKASI ERROR -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-200 text-red-700 p-4 mb-6 rounded-2xl">
                        <ul class="list-disc list-inside text-sm font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('perusahaan.register.submit') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Perusahaan / Instansi <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required 
                               class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Email Resmi <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">No. Telepon HRD <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp_wa" value="{{ old('no_hp_wa') }}" required 
                                   class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Kantor <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="2" required 
                                  class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required 
                                   class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-bold py-4 rounded-2xl transition-all mt-4 shadow-lg shadow-emerald-600/30">
                        Ajukan Kemitraan Perusahaan
                    </button>
                </form>

                <p class="mt-6 text-center text-sm font-medium text-slate-500">
                    Sudah terdaftar sebagai mitra? 
                    <a href="{{ route('perusahaan.login') }}" class="text-emerald-600 hover:text-emerald-700 font-bold ml-1 transition">Masuk di sini</a>
                </p>
            </div>
        </div>

        <!-- Kolom Kiri: Abstract Gradient Panel -->
        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center overflow-hidden bg-slate-900 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-teal-900 to-slate-900 opacity-90"></div>
            <div class="absolute top-10 left-10 w-96 h-96 bg-emerald-500 rounded-full mix-blend-overlay filter blur-[100px] opacity-50"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-cyan-600 rounded-full mix-blend-overlay filter blur-[100px] opacity-50"></div>
            
            <div class="absolute inset-0 opacity-[0.15]" style="background-image: repeating-linear-gradient(45deg, white 25%, transparent 25%, transparent 75%, white 75%, white), repeating-linear-gradient(45deg, white 25%, transparent 25%, transparent 75%, white 75%, white); background-position: 0 0, 20px 20px; background-size: 40px 40px;"></div>

            <div class="relative z-10 w-3/4 backdrop-blur-md bg-white/10 border border-white/10 p-12 rounded-[2.5rem] shadow-2xl text-white text-center">
                <i class="fas fa-handshake text-6xl mb-6 text-emerald-300"></i>
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Kemitraan Strategis</h1>
                <p class="text-lg text-emerald-100 font-medium leading-relaxed">
                    Temukan kandidat berkualitas yang siap kerja dengan kompetensi yang sesuai dengan kebutuhan industri Anda.
                </p>
            </div>
        </div>
    </div>
</body>
</html>