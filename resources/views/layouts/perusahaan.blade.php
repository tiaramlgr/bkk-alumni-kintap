<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Perusahaan - BKK Kintap')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<form id="logout-form-perusahaan" action="{{ route('perusahaan.logout') }}" method="POST" class="hidden">
    @csrf
</form>

<div class="flex h-screen">
    <div class="w-72 bg-white border-r shadow-xl flex flex-col justify-between">
        <div>
            <div class="p-6 bg-emerald-700 text-white">
                <h1 class="text-2xl font-bold">BKK Kintap</h1>
                <p class="text-sm opacity-90">Portal Perusahaan</p>
            </div>
            
            
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('perusahaan.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('perusahaan.dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-emerald-50' }}">
                    <i class="fas fa-home w-5"></i> Dashboard
                </a>
                <a href="{{ route('perusahaan.lowongan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('perusahaan.lowongan.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-emerald-50' }}">
                    <i class="fas fa-briefcase w-5"></i> Lowongan Saya
                </a>
                <a href="{{ route('perusahaan.lamaran.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('perusahaan.lamaran.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-emerald-50' }}">
                    <i class="fas fa-users w-5"></i> Data Pelamar
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-slate-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center font-bold text-emerald-800 border border-emerald-200">
                    {{ substr(auth()->user()->name ?? 'P', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="font-bold text-sm text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-emerald-600 uppercase tracking-wider">Perusahaan</p>
                </div>
            </div>

            <a href="{{ route('perusahaan.logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form-perusahaan').submit();"
               class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-2xl transition shadow-lg shadow-red-500/20 text-sm">
                <i class="fas fa-power-off"></i> Keluar Website
            </a>
        </div>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-slate-800">@yield('title', 'Dashboard Perusahaan')</h2>
        </header>
        
        <div class="flex-1 overflow-auto p-8">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>