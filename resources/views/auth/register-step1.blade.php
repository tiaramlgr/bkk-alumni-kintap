<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alumni - BKK SMKN Kintap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen flex">
        
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 relative z-20">
            <div class="max-w-md w-full">
                <div class="mb-6 text-center lg:text-left">
                    <span class="inline-block py-1.5 px-3 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4">Pendaftaran Baru</span>
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Buat Akun Alumni</h2>
                    <p class="text-slate-500 font-medium">Lengkapi data dasar Anda untuk bergabung dengan jejaring alumni.</p>
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

                <form method="POST" action="{{ route('register.step1') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap Sesuai Ijazah <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition-all bg-slate-50 hover:bg-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">NISN <span class="text-red-500">*</span></label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" required 
                               class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition-all bg-slate-50 hover:bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Aktif <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition-all bg-slate-50 hover:bg-white">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required 
                                   class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition-all bg-slate-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Ulangi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition-all bg-slate-50 hover:bg-white">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-black active:scale-[0.98] text-white font-bold py-4 rounded-2xl transition-all mt-4 shadow-lg shadow-slate-900/30 flex justify-center items-center gap-2">
                        Daftarkan Akun <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm font-medium text-slate-500">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-bold ml-1 transition">Masuk di sini</a>
                </p>
            </div>
        </div>

        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center overflow-hidden bg-slate-100 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-tr from-sky-100 via-blue-50 to-white"></div>
            <div class="absolute top-20 right-20 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-[70px] opacity-40"></div>
            <div class="absolute bottom-20 left-20 w-80 h-80 bg-teal-200 rounded-full mix-blend-multiply filter blur-[70px] opacity-40"></div>
            
            <div class="relative z-10 w-3/4 bg-white/60 backdrop-blur-xl border border-white p-12 rounded-[2.5rem] shadow-xl text-center">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-blue-500/40">
                        <i class="fas fa-user-graduate text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-800 mb-4 tracking-tight">Bergabunglah dengan<br>Keluarga Besar Alumni</h1>
                <p class="text-slate-600 font-medium leading-relaxed">
                    Akses ratusan lowongan eksklusif dari mitra industri kami dan tetap terhubung dengan almamater tercinta.
                </p>
            </div>
        </div>
    </div>
</body>
</html>