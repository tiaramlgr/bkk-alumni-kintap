<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil - BKK SMKN Kintap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <div class="flex items-center justify-center p-8 md:p-16 relative z-20">
            <div class="max-w-md w-full">
                <div class="mb-8 text-center lg:text-left">
                    <span class="inline-block py-1.5 px-3 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4">Langkah 2 dari 2</span>
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Lengkapi Data Diri</h2>
                    <p class="text-slate-500 font-medium">Satu langkah lagi untuk menyelesaikan profil alumni Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-200 text-red-700 p-4 mb-6 rounded-2xl">
                        <ul class="list-disc list-inside text-sm font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/register/step2') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap Sesuai Ijazah <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap"
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-600 outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">NISN <span class="text-red-500">*</span></label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="10 Digit NISN"
                                   class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-600 outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Lulus <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus') }}" required placeholder="Misal: 2024"
                                   class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-600 outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">No. HP / WhatsApp Aktif <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp_wa" value="{{ old('no_hp_wa') }}" required placeholder="08xxxxxxxxxx"
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-600 outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jurusan / Kompetensi Keahlian <span class="text-red-500">*</span></label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" required placeholder="Misal Teknik Komputer dan Jaringan"
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-600 outline-none transition-all bg-slate-50 hover:bg-white text-slate-700">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold py-4 rounded-2xl transition-all mt-6 shadow-lg shadow-indigo-600/30 flex justify-center items-center gap-2">
                        Selesaikan Pendaftaran <i class="fas fa-check-circle"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="hidden lg:flex relative items-center justify-center overflow-hidden bg-slate-900 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-800 via-purple-900 to-slate-900 opacity-90"></div>
            
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-fuchsia-500 rounded-full mix-blend-screen filter blur-[90px] opacity-50"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-500 rounded-full mix-blend-screen filter blur-[90px] opacity-50"></div>
            
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>

            <div class="relative z-10 w-[80%] max-w-lg backdrop-blur-md bg-white/10 border border-white/20 p-12 rounded-[2.5rem] shadow-2xl text-white text-center">
                <i class="fas fa-id-card text-6xl mb-6 text-indigo-300"></i>
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Validasi Data Alumni</h1>
                <p class="text-lg text-indigo-100 font-medium leading-relaxed">
                    Pastikan NISN dan Tahun Lulus sesuai dengan ijazah Anda agar proses verifikasi oleh Admin BKK dapat berjalan cepat.
                </p>
            </div>
        </div>
    </div>
</body>
</html>