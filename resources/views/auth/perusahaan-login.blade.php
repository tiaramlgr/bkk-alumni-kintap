<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Login - BKK SMKN Kintap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen flex flex-row-reverse">
        
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-24 relative z-10">
            <div class="max-w-md w-full">
                <div class="mb-10 text-center lg:text-left">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl mb-6 shadow-inner">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Portal Mitra Industri</h2>
                    <p class="text-slate-500 font-medium">Masuk untuk mencari talenta terbaik dari lulusan kami.</p>
                </div>

                 <form method="POST" action="{{ route('perusahaan.login') }}">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Perusahaan</label>
                        <input type="email" name="email" required placeholder="email@perusahaan.com"
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-emerald-600/30">
                        Masuk ke Portal HR
                    </button>
                </form>

                <p class="mt-8 text-center text-sm font-medium text-slate-500">
                    Ingin merekrut lulusan kami? 
                    <a href="{{ route('perusahaan.register') }}" class="text-emerald-600 hover:text-emerald-700 font-bold ml-1 transition">Daftarkan Perusahaan</a>
                </p>
            </div>
        </div>

        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center overflow-hidden bg-slate-900">
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