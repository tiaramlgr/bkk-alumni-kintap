<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin BKK Kintap')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <div class="w-72 bg-white border-r shadow-xl flex flex-col">
            <div class="p-6 border-b bg-blue-700 text-white">
                <h1 class="text-2xl font-bold">BKK Kintap</h1>
                <p class="text-sm opacity-90">SMK Negeri Kintap</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <i class="fas fa-home w-5"></i> Dashboard
                </a>
                
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 mt-4">MANAJEMEN UTAMA</div>
                
                <a href="{{ route('admin.alumni.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50">
                    <i class="fas fa-users w-5"></i> Kelola Alumni
                </a>
                
                @php
                    $isMasterData = request()->routeIs('admin.jurusan.*') || request()->routeIs('admin.kategori-lowongan.*');
                @endphp
                <div>
                    <button type="button" onclick="document.getElementById('masterDataMenu').classList.toggle('hidden'); document.getElementById('masterDataIcon').classList.toggle('rotate-180');" 
                            class="w-full flex items-center justify-between px-4 py-3 rounded-2xl transition-colors {{ $isMasterData ? 'bg-blue-50 text-blue-700' : 'hover:bg-blue-50 text-gray-700' }}">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-database w-5"></i> 
                            <span>Master Data</span>
                        </div>
                        <i id="masterDataIcon" class="fas fa-chevron-down text-xs transition-transform duration-200 {{ $isMasterData ? 'rotate-180' : '' }}"></i>
                    </button>
                    
                    <div id="masterDataMenu" class="{{ $isMasterData ? 'block' : 'hidden' }} mt-1 space-y-1 pl-9 pr-2">
                        <a href="{{ route('admin.jurusan.index') }}" class="block px-4 py-2 text-sm rounded-xl transition-colors {{ request()->routeIs('admin.jurusan.*') ? 'text-blue-700 font-semibold bg-blue-50' : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50' }}">
                            Kelola Jurusan
                        </a>
                        <a href="{{ route('admin.kategori-lowongan.index') }}" class="block px-4 py-2 text-sm rounded-xl transition-colors {{ request()->routeIs('admin.kategori-lowongan.*') ? 'text-blue-700 font-semibold bg-blue-50' : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50' }}">
                            Kategori Lowongan
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.lowongan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50">
                    <i class="fas fa-briefcase w-5"></i> Lowongan Kerja
                </a>
                
                <a href="{{ route('alumni.dokumen.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50">
                    <i class="fas fa-file-upload w-5"></i> Dokumen Alumni
                </a>
                
                <a href="{{ route('admin.siaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50">
                    <i class="fas fa-paper-plane w-5"></i> Siaran WhatsApp
                </a>

                <div class="px-4 py-2 text-xs font-semibold text-gray-500 mt-4">LAINNYA</div>
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50">
                    <i class="fas fa-chart-bar w-5"></i> Tracer Study
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50">
                    <i class="fas fa-history w-5"></i> Activity Log
                </a>
                <a href="{{ route('admin.export.alumni') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-blue-50">
                    <i class="fas fa-file-excel w-5"></i> Export Data Alumni
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b px-8 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold">@yield('title')</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm">{{ auth()->user()->name ?? 'Admin BKK' }}</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="text-red-600 hover:text-red-700">Logout</a>
                </div>
            </header>
            
            <div class="flex-1 overflow-auto p-8">
                @yield('content')
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</body>
</html>