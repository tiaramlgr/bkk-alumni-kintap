@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-bold text-slate-800">Admin Dashboard</h1>
        <p class="text-slate-500 mt-2">Panel Pengelolaan Lengkap BKK SMK Negeri Kintap</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Alumni</p>
                <p class="text-5xl font-black text-blue-600 mt-3">{{ \App\Models\Alumni::count() }}</p>
            </div>
            <div class="text-xs text-slate-400 mt-4 flex items-center gap-1">
                <i class="fas fa-graduation-cap"></i> Terdaftar di sistem
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Lowongan Aktif</p>
                <p class="text-5xl font-black text-emerald-600 mt-3">{{ \App\Models\LowonganKerja::where('status', 'aktif')->count() }}</p>
            </div>
            <div class="text-xs text-slate-400 mt-4 flex items-center gap-1">
                <i class="fas fa-briefcase"></i> Siap dilamar alumni
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Pending Approval</p>
                <p class="text-5xl font-black text-orange-600 mt-3">{{ \App\Models\Alumni::where('status_akun', 'pending')->count() }}</p>
            </div>
            <div class="text-xs text-slate-400 mt-4 flex items-center gap-1">
                <i class="fas fa-user-clock"></i> Akun alumni baru
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Lamaran Masuk</p>
                <p class="text-5xl font-black text-purple-600 mt-3">{{ \App\Models\Lamaran::where('status_lamaran', 'pending')->count() }}</p>
            </div>
            <div class="text-xs text-slate-400 mt-4 flex items-center gap-1">
                <i class="fas fa-file-alt"></i> Menunggu review mitra
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                        <i class="fas fa-history text-slate-400"></i> Log Aktivitas Sistem
                    </h3>
                    <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full font-medium">Real-time</span>
                </div>
                
                <div class="space-y-4">
                    @php
                        // Mengambil log aktivitas sistem dari database proyek Anda
                        $logs = \App\Models\ActivityLog::with('user')->latest()->take(4)->get();
                    @endphp

                    @forelse($logs as $log)
                        <div class="flex items-start gap-3 text-sm pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                            <div class="flex-1">
                                <p class="text-slate-700 font-medium"><span class="font-bold text-slate-900">{{ $log->user->name ?? 'Sistem' }}</span> {{ $log->action }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-sm">
                            <i class="fas fa-info-circle text-2xl mb-2 block text-slate-200"></i>
                            Belum ada log rekaman aktivitas terbaru di platform.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-slate-400"></i> Status Serapan Kerja Alumni
                    </h3>
                    <a href="{{ route('admin.export.alumni') }}" class="text-xs text-blue-600 hover:underline">Lihat Detail Laporan</a>
                </div>

                <div class="space-y-4">
                    @php
                        // Kalkulasi persentase data kuesioner tracer study dari database proyek Anda
                        $totalTracer = \App\Models\TracerStudy::count() ?: 1;
                        $kerja = \App\Models\TracerStudy::where('status_aktivitas', 'bekerja')->count();
                        $usaha = \App\Models\TracerStudy::where('status_aktivitas', 'wirausaha')->count();
                        $kuliah = \App\Models\TracerStudy::where('status_aktivitas', 'kuliah')->count();
                        
                        $pKerja = round(($kerja / $totalTracer) * 100);
                        $pUsaha = round(($usaha / $totalTracer) * 100);
                        $pKuliah = round(($kuliah / $totalTracer) * 100);
                    @endphp

                    <div>
                        <div class="flex justify-between text-sm font-medium mb-1.5">
                            <span class="text-slate-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Bekerja</span>
                            <span class="font-bold text-slate-800">{{ $kerja }} Alumni ({{ $pKerja }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full" style="width: {{ $pKerja }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm font-medium mb-1.5">
                            <span class="text-slate-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Wirausaha</span>
                            <span class="font-bold text-slate-800">{{ $usaha }} Alumni ({{ $pUsaha }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-full" style="width: {{ $pUsaha }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm font-medium mb-1.5">
                            <span class="text-slate-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Kuliah / Studi Lanjut</span>
                            <span class="font-bold text-slate-800">{{ $kuliah }} Alumni ({{ $pKuliah }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full" style="width: {{ $pKuliah }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection