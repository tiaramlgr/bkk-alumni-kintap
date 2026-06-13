<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKK Alumni SMK Negeri Kintap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; }
        .blob-bg {
            background-image: radial-gradient(circle at 100% 100%, #1e3a8a 0, #1e3a8a 3px, transparent 3px), radial-gradient(circle at 0 0, #1e3a8a 0, #1e3a8a 3px, transparent 3px), radial-gradient(circle at 0 100%, #1e3a8a 0, #1e3a8a 3px, transparent 3px), radial-gradient(circle at 100% 0, #1e3a8a 0, #1e3a8a 3px, transparent 3px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="font-sans text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <!-- Logo Kiri -->
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 text-white p-2 rounded-xl">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">BKK Kintap</h1>
            </div>

            <!-- Menu Tengah -->
            <div class="hidden md:flex items-center gap-8 font-medium text-slate-600">
                <a href="#lowongan" class="hover:text-blue-600 transition">Lowongan</a>
                <a href="#berita" class="hover:text-blue-600 transition">Berita</a>
                <a href="#pengumuman" class="hover:text-blue-600 transition">Pengumuman</a>
            </div>

            <!-- START: Navigasi Kanan -->
            <div class="flex items-center gap-3">
                
                <!-- DROPDOWN MASUK -->
                <div class="relative group">
                    <button class="font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-2 px-4 py-2.5 rounded-xl hover:bg-blue-50 transition">
                        <i class="fas fa-sign-in-alt text-blue-500"></i> Masuk <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                        <div class="p-3 border-b border-slate-50">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider px-2">Masuk Sebagai</span>
                        </div>
                        <a href="{{ route('login') }}" class="block px-4 py-3 hover:bg-blue-50 rounded-xl m-1.5 transition">
                            <div class="font-bold text-slate-800"><i class="fas fa-user-graduate w-6 text-blue-500"></i> Alumni / Admin</div>
                            <div class="text-xs text-slate-500 ml-7 mt-0.5">Masuk ke portal utama</div>
                        </a>
                        <a href="{{ route('perusahaan.login') }}" class="block px-4 py-3 hover:bg-blue-50 rounded-xl m-1.5 transition">
                            <div class="font-bold text-slate-800"><i class="fas fa-building w-6 text-amber-500"></i> Perusahaan</div>
                            <div class="text-xs text-slate-500 ml-7 mt-0.5">Masuk ke portal mitra</div>
                        </a>
                    </div>
                </div>
                
                <div class="h-6 w-px bg-slate-200 mx-2"></div>
                
                <!-- DROPDOWN DAFTAR -->
                <div class="relative group">
                    <button class="bg-blue-600 text-white px-6 py-2.5 rounded-xl hover:bg-blue-700 transition font-bold flex items-center gap-2 shadow-sm">
                        Daftar <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                        <div class="p-3 border-b border-slate-50">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider px-2">Pilih Tipe Akun</span>
                        </div>
                        <a href="/register/step1" class="block px-4 py-3 hover:bg-blue-50 rounded-xl m-1.5 transition">
                            <div class="font-bold text-slate-800"><i class="fas fa-user-plus w-6 text-blue-500"></i> Alumni Baru</div>
                            <div class="text-xs text-slate-500 ml-7 mt-0.5">Untuk lulusan pencari kerja</div>
                        </a>
                        <a href="{{ route('perusahaan.register') }}" class="block px-4 py-3 hover:bg-blue-50 rounded-xl m-1.5 transition">
                            <div class="font-bold text-slate-800"><i class="fas fa-building w-6 text-amber-500"></i> Perusahaan Baru</div>
                            <div class="text-xs text-slate-500 ml-7 mt-0.5">Untuk mitra penyedia loker</div>
                        </a>
                    </div>
                </div>

            </div>
            <!-- END: Navigasi Kanan -->

        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="bg-[#0b132b] text-white pt-24 pb-32 relative overflow-hidden rounded-b-[3rem] shadow-xl z-10">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 blob-bg"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-40"></div>
        
        <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-900/50 border border-blue-700/50 text-blue-300 text-sm font-semibold tracking-wide mb-6">
                🚀 Portal Karir Resmi SMK Negeri Kintap
            </span>
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 tracking-tight">
                Hubungkan Masa Depanmu <br> <span class="text-blue-400">dengan Jejaring Industri</span>
            </h1>
            <p class="text-lg text-slate-300 mb-12 max-w-2xl mx-auto leading-relaxed">
                Platform BKK cerdas untuk mengelola tracer study, menemukan lowongan kerja eksklusif, dan menghubungkan lulusan langsung dengan perusahaan mitra terpercaya.
            </p>
            
            <!-- START: Tombol Aksi Utama di Hero -->
            <div class="flex flex-col md:flex-row gap-8 justify-center items-center mt-10 bg-slate-900/50 p-4 md:p-6 rounded-3xl border border-slate-700/50 backdrop-blur-sm max-w-3xl mx-auto">
                
                <!-- Kolom Masuk -->
                <div class="w-full flex-1">
                    <p class="text-slate-400 text-sm font-medium mb-3">Sudah punya akun?</p>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2 border border-blue-500">
                            <i class="fas fa-sign-in-alt w-5"></i> Masuk Alumni/Admin
                        </a>
                        <a href="{{ route('perusahaan.login') }}" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2 border border-slate-700">
                            <i class="fas fa-building w-5 text-amber-400"></i> Masuk Perusahaan
                        </a>
                    </div>
                </div>

                <!-- Pemisah -->
                <div class="hidden md:block w-px h-24 bg-slate-700"></div>
                <div class="block md:hidden w-full h-px bg-slate-700 my-2"></div>

                <!-- Kolom Daftar -->
                <div class="w-full flex-1">
                    <p class="text-slate-400 text-sm font-medium mb-3">Pengguna baru?</p>
                    <div class="flex flex-col gap-2">
                        <a href="/register/step1" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2 border border-slate-700">
                            <i class="fas fa-user-plus w-5 text-blue-400"></i> Daftar Alumni
                        </a>
                        <a href="{{ route('perusahaan.register') }}" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2 border border-slate-700">
                            <i class="fas fa-handshake w-5 text-emerald-400"></i> Daftar Perusahaan
                        </a>
                    </div>
                </div>

            </div>
            <!-- END: Tombol Aksi Utama di Hero -->

        </div>
    </section>

    <!-- LOWONGAN SECTION -->
    <section id="lowongan" class="py-20 max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Peluang Karir Terbaru</h2>
                <p class="text-slate-500">Temukan posisi terbaik yang diunggah oleh Admin dan Mitra Perusahaan.</p>
            </div>
            <a href="{{ route('login') }}" class="hidden md:inline-flex text-blue-600 font-semibold hover:text-blue-700 items-center gap-2">
                Lihat Semua Lowongan <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($lowongans as $loker)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:border-blue-200 transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 font-bold text-xl">
                            <i class="{{ $loker->kategori->icon ?? 'fas fa-briefcase' }}"></i>
                        </div>
                        <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase">
                            {{ str_replace('_', ' ', $loker->tipe_pekerjaan) }}
                        </span>
                    </div>
                    <a href="{{ route('login') }}" class="block text-xl font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition line-clamp-2">
                        {{ $loker->judul_lowongan }}
                    </a>
                    <p class="text-slate-500 text-sm font-medium mb-4">{{ $loker->nama_perusahaan }}</p>
                    <div class="flex flex-col gap-2 mb-6">
                        <div class="flex items-center gap-2 text-sm text-slate-600"><i class="fas fa-map-marker-alt w-4 text-slate-400"></i> {{ $loker->lokasi }}</div>
                        <div class="flex items-center gap-2 text-sm text-slate-600"><i class="fas fa-calendar-alt w-4 text-slate-400"></i> Batas: {{ \Carbon\Carbon::parse($loker->deadline)->format('d M Y') }}</div>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="block w-full py-3 px-4 bg-slate-50 border border-slate-100 text-slate-700 text-center font-semibold rounded-xl group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition mt-auto">
                    Masuk untuk Melamar
                </a>
            </div>
            @empty
            <div class="col-span-3 bg-slate-50 rounded-3xl p-10 text-center border border-dashed border-slate-200">
                <i class="fas fa-folder-open text-4xl text-slate-300 mb-3"></i>
                <h3 class="text-lg font-bold text-slate-600">Belum Ada Lowongan</h3>
                <p class="text-slate-500 text-sm">Lowongan kerja terbaru akan muncul di sini.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- BERITA SECTION (Dipindah ke atas Pengumuman) -->
    <section id="berita" class="py-20 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header Berita -->
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Berita & Informasi Terbaru</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Ikuti perkembangan terbaru, kegiatan alumni, dan informasi penting lainnya dari BKK SMK Negeri Kintap.</p>
            </div>

            <!-- Grid Kartu Berita -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($beritas as $berita)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                    <!-- Thumbnail Foto -->
                    <div class="h-52 bg-slate-100 relative overflow-hidden group">
                        @if($berita->foto)
                            <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-newspaper text-5xl text-blue-200"></i>
                            </div>
                        @endif
                        <!-- Label Tanggal -->
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-sm text-blue-700 text-xs font-bold px-4 py-2 rounded-xl shadow-sm">
                                <i class="fas fa-calendar-alt mr-1"></i> {{ $berita->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Konten Teks -->
                    <div class="p-8 flex flex-col flex-1">
                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 hover:text-blue-600 transition">
                            <a href="#">{{ $berita->judul }}</a>
                        </h3>
                        <p class="text-slate-500 text-sm mb-6 line-clamp-3 leading-relaxed flex-1">
                            {{ Str::limit(strip_tags($berita->konten), 120) }}
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-slate-100">
                            <a href="#" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm hover:text-blue-800 transition group">
                                Baca Selengkapnya <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-dashed border-slate-300">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 text-slate-300 rounded-full mb-4">
                        <i class="fas fa-newspaper text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Publikasi</h3>
                    <p class="text-slate-500">Berita dan artikel terbaru akan segera hadir di ruang ini.</p>
                </div>
                @endforelse
            </div>
            
            @if($beritas->count() > 0)
            <div class="text-center mt-12">
                <a href="#" class="inline-block border border-slate-300 text-slate-600 font-semibold px-8 py-3.5 rounded-2xl hover:bg-slate-50 hover:text-blue-600 transition">
                    Lihat Semua Berita
                </a>
            </div>
            @endif
            
        </div>
    </section>

    <!-- PENGUMUMAN SECTION -->
    <section id="pengumuman" class="py-20 bg-slate-900 text-white mt-10 rounded-t-[3rem] flex-grow">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500/20 text-blue-400 rounded-2xl mb-6">
                    <i class="fas fa-trophy text-3xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold mb-4">Papan Pengumuman Rekrutmen</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Selamat kepada alumni yang telah dinyatakan lolos seleksi dan resmi diterima bekerja. Silakan unduh surat pengumuman resmi di bawah ini.</p>
            </div>

            <div class="bg-slate-800 rounded-3xl p-6 md:p-8 border border-slate-700 shadow-2xl">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 pb-6 border-b border-slate-700 gap-4">
                    <h3 class="text-xl font-bold text-white"><i class="fas fa-bullhorn text-amber-400 mr-2"></i> Hasil Seleksi Terbaru</h3>
                    
                    @if($pengumumans->count() > 0)
                    <a href="{{ route('pengumuman.pdf') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i> Download Pengumuman (PDF)
                    </a>
                    @endif
                </div>

                <div class="space-y-4">
                    @forelse($pengumumans as $p)
                    <div class="flex flex-col sm:flex-row justify-between items-center p-4 bg-slate-700/50 rounded-2xl border border-slate-600 hover:bg-slate-700 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-600 rounded-full flex items-center justify-center font-bold text-slate-300 uppercase">
                                {{ substr($p->alumni->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-lg">{{ $p->alumni->user->name }}</h4>
                                <p class="text-sm text-slate-400">{{ $p->alumni->jurusan->nama_jurusan ?? 'Alumni SMKN Kintap' }}</p>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0 text-right">
                            <span class="block font-medium text-emerald-400">{{ $p->lowongan->nama_perusahaan }}</span>
                            <span class="text-xs text-slate-400">{{ $p->lowongan->judul_lowongan }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-slate-800/50 rounded-2xl border border-dashed border-slate-600">
                        <i class="fas fa-clipboard-list text-4xl text-slate-600 mb-3"></i>
                        <p class="text-slate-400 font-medium">Belum ada pengumuman hasil seleksi saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#0b132b] text-slate-400 py-8 border-t border-slate-800 text-center">
        <p class="text-sm">© {{ date('Y') }} Bursa Kerja Khusus SMK Negeri Kintap. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>