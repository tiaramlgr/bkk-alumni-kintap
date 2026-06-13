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
            
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-home w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Dashboard</span>
                </a>
                
                <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-4 mb-2">Manajemen Utama</div>
                
                <a href="{{ route('admin.alumni.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.alumni.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-users w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Kelola Alumni</span>
                </a>

                <a href="{{ route('admin.tracer.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.tracer.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-route w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Tracer Study</span>
                </a>
                
                <a href="{{ route('admin.lowongan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.lowongan.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-briefcase w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Lowongan Kerja</span>
                </a>                
                
                <a href="{{ route('admin.berita.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.berita.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-newspaper w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Kelola Berita</span>
                </a>

                <a href="{{ route('admin.dokumen.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.dokumen.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-folder-open w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Dokumen Alumni</span>
                </a>

                <a href="{{ route('admin.siaran.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.siaran.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-paper-plane w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Siaran WhatsApp</span>
                </a>

                <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-4 mb-2">Lainnya</div>

                <a href="{{ route('admin.perusahaan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.perusahaan.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-building w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Kelola Perusahaan</span>
                </a>   

                <a href="{{ route('admin.activity-log') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.activity-log') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-history w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Activity Log</span>
                </a>

                <a href="{{ route('admin.export.alumni') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.export.alumni') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700 font-medium' }}">
                    <i class="fas fa-file-excel w-5 text-center transition-transform group-hover:scale-110"></i> 
                    <span>Export Data Alumni</span>
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b px-8 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-slate-800">@yield('title')</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-slate-600">{{ auth()->user()->name ?? 'Admin BKK' }}</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="text-red-600 hover:text-red-700 font-semibold text-sm transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
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