<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Alumni SMKN Kintap')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans">
    <div class="flex h-screen">
        <div class="w-72 bg-white border-r border-slate-200 flex flex-col justify-between shadow-sm">
            <div>
                <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-blue-700 to-blue-800 text-white">
                    <h1 class="text-2xl font-black tracking-tight">BKK Kintap</h1>
                    <p class="text-xs opacity-80 uppercase tracking-wider font-semibold mt-0.5">Alumni Portal</p>
                </div>
                
                <nav class="p-4 space-y-1">
                    <a href="{{ route('alumni.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('alumni.dashboard') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm shadow-blue-500/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-home w-5 text-center text-base"></i> Dashboard
                    </a>
                    
                    <a href="{{ route('alumni.tracer.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('alumni.tracer.*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm shadow-blue-500/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-paste w-5 text-center text-base"></i>  Tracer Study
                    </a>
                    
                    <a href="{{ route('alumni.lowongan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('alumni.lowongan.*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm shadow-blue-500/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-search-location w-5 text-center text-base"></i> Info Lowongan Kerja
                    </a>

                    <a href="{{ route('alumni.lamaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('alumni.lamaran.*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm shadow-blue-500/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-history w-5 text-center text-base"></i> Riwayat Lamaran Saya
                    </a>

                    <a href="{{ route('alumni.dokumen.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('alumni.dokumen.*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm shadow-blue-500/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-folder-open w-5 text-center text-base"></i> Berkas Dokumen
                    </a>
                    
                    <a href="{{ route('alumni.profil.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('alumni.profil.*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm shadow-blue-500/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-user-edit w-5 text-center text-base"></i> Pengaturan Profil
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-3 mb-3 px-2">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-md shadow-blue-600/10">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="truncate">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Alumni</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-slate-200 hover:bg-rose-600 text-slate-700 hover:text-white transition-all font-semibold px-4 py-3 rounded-xl text-sm flex items-center justify-center gap-2 shadow-sm">
                        <i class="fas fa-power-off text-xs"></i> Keluar Website
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-slate-200 px-8 py-5 flex justify-between items-center shadow-sm">
                <h2 class="text-xl font-bold text-slate-800">@yield('title')</h2>
                <div class="text-right">
                    <span class="text-xs bg-blue-50 text-blue-700 border border-blue-200 font-bold px-3 py-1 rounded-full">
                        Tahun Kelulusan: {{ auth()->user()->alumni->tahun_lulus ?? '2026' }}
                    </span>
                </div>
            </header>
            
            <main class="flex-1 overflow-auto p-8">
                @if(session('error'))
                    <div class="max-w-5xl mx-auto mb-6 bg-rose-100 border border-rose-400 text-rose-800 px-4 py-3 rounded-2xl text-center font-medium">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>