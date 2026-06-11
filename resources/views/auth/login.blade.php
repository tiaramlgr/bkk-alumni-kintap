<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BKK SMKN Kintap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans antialiased">
    <!-- UBAH DISINI: Menggunakan CSS Grid agar rasio layar kaku 50:50 -->
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <!-- Kolom Kiri: Form Login -->
        <div class="flex items-center justify-center p-8 md:p-24 relative z-20">
            <div class="max-w-md w-full">
                <!-- Logo / Header -->
                <div class="mb-8 text-center lg:text-left">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl mb-6 shadow-inner">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Selamat Datang! 👋</h2>
                    <p class="text-slate-500 font-medium">Silakan masuk ke akun Anda untuk mengakses portal BKK SMKN Kintap.</p>
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

                <!-- Form -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email / NISN</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan Email"
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-bold text-slate-700">Password</label>
                            <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition">Lupa Password?</a>
                        </div>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-blue-600/30 mt-4">
                        Masuk ke Dashboard
                    </button>
                </form>

                <p class="mt-8 text-center text-sm font-medium text-slate-500">
                    Belum punya akun alumni? 
                    <!-- RUTE PENDAFTARAN SUDAH BENAR DI SINI -->
                    <a href="/register/step1" class="text-blue-600 hover:text-blue-700 font-bold ml-1 transition">Daftar Sekarang</a>
                </p>
            </div>
        </div>

        <!-- Kolom Kanan: Abstract Gradient Panel -->
        <div class="hidden lg:flex relative items-center justify-center overflow-hidden bg-slate-900 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-indigo-800 to-slate-900 opacity-90"></div>
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-60"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-purple-500 rounded-full mix-blend-screen filter blur-[80px] opacity-60"></div>
            
            <div class="relative z-10 w-[80%] max-w-lg backdrop-blur-md bg-white/10 border border-white/20 p-12 rounded-[2.5rem] shadow-2xl text-white text-center">
                <i class="fas fa-network-wired text-6xl mb-6 text-blue-200"></i>
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Membangun Karir<br>Masa Depan</h1>
                <p class="text-lg text-blue-100 font-medium leading-relaxed">
                    Sistem Informasi Bursa Kerja Khusus SMK Negeri Kintap. Menjembatani lulusan hebat dengan industri terkemuka.
                </p>
            </div>
        </div>
    </div>
</body>
</html>