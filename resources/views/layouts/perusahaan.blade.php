<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Perusahaan - BKK Kintap')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<form id="logout-form-perusahaan" action="{{ route('perusahaan.logout') }}" method="POST" class="hidden">
    @csrf
</form>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar Perusahaan -->
        <div class="w-72 bg-white border-r shadow-xl flex flex-col">
            <div class="p-6 border-b bg-emerald-700 text-white">
                <h1 class="text-2xl font-bold">BKK Kintap</h1>
                <p class="text-sm opacity-90">Portal Perusahaan</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('perusahaan.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-emerald-50 {{ request()->routeIs('perusahaan.dashboard') ? 'bg-emerald-50 text-emerald-700 font-medium' : '' }}">
                    <i class="fas fa-home w-5"></i> Dashboard
                </a>
                <a href="{{ route('perusahaan.lowongan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-emerald-50">
                    <i class="fas fa-briefcase w-5"></i> Lowongan Saya
                </a>
                <a href="{{ route('perusahaan.lamaran.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-emerald-50">
                    <i class="fas fa-users w-5"></i> Data Pelamar
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-emerald-50">
                    <i class="fas fa-paper-plane w-5"></i> Kirim Lowongan
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b px-8 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold">@yield('title', 'Dashboard Perusahaan')</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm">{{ auth()->user()->name }}</span>
                    <a href="{{ route('perusahaan.logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form-perusahaan').submit();"
                    class="text-red-600 hover:text-red-700">
                        Logout
                    </a>
                </div>
            </header>
            
            <div class="flex-1 overflow-auto p-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>