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

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-4">
            <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2">
                <i class="fas fa-chart-pie text-slate-400"></i> Ringkasan Status Serapan Kerja Alumni
            </h3>
            <a href="{{ route('admin.export.alumni') }}" class="text-sm font-semibold text-blue-600 hover:underline">Lihat Detail Laporan</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @php
                $totalTracer = \App\Models\TracerStudy::count() ?: 1;
                $kerja = \App\Models\TracerStudy::where('status_aktivitas', 'bekerja')->count();
                $usaha = \App\Models\TracerStudy::where('status_aktivitas', 'wirausaha')->count();
                $kuliah = \App\Models\TracerStudy::where('status_aktivitas', 'kuliah')->count();
                $belumTerserap = \App\Models\TracerStudy::whereIn('status_aktivitas', ['menganggur', 'lainnya'])->count();
                
                $pKerja = round(($kerja / $totalTracer) * 100);
                $pUsaha = round(($usaha / $totalTracer) * 100);
                $pKuliah = round(($kuliah / $totalTracer) * 100);
                $pBelumTerserap = round(($belumTerserap / $totalTracer) * 100);
            @endphp

            <div>
                <div class="flex justify-between text-sm font-medium mb-2">
                    <span class="text-slate-600 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Bekerja</span>
                    <span class="font-bold text-slate-800">{{ $kerja }} Alumni ({{ $pKerja }}%)</span>
                </div>
                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full" style="width: {{ $pKerja }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm font-medium mb-2">
                    <span class="text-slate-600 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Wirausaha</span>
                    <span class="font-bold text-slate-800">{{ $usaha }} Alumni ({{ $pUsaha }}%)</span>
                </div>
                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full" style="width: {{ $pUsaha }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm font-medium mb-2">
                    <span class="text-slate-600 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Kuliah / Studi Lanjut</span>
                    <span class="font-bold text-slate-800">{{ $kuliah }} Alumni ({{ $pKuliah }}%)</span>
                </div>
                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                    <div class="bg-blue-500 h-full" style="width: {{ $pKuliah }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm font-medium mb-2">
                    <span class="text-slate-600 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-rose-500"></span> Mencari Kerja / Lainnya</span>
                    <span class="font-bold text-slate-800">{{ $belumTerserap }} Alumni ({{ $pBelumTerserap }}%)</span>
                </div>
                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                    <div class="bg-rose-500 h-full" style="width: {{ $pBelumTerserap }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2">
                <i class="fas fa-chart-bar text-blue-500"></i> Statistik Karir Lulusan per Jurusan (Tahun Laporan: {{ date('Y') }})
            </h3>
        </div>
        
        <div class="relative h-96 w-full">
            <canvas id="jurusanChart"></canvas>
        </div>
    </div>

    @php
        $tahunIni = date('Y');
        $jurusans = \App\Models\Jurusan::all();
        $labels = [];
        $dataBekerja = [];
        $dataWirausaha = [];
        $dataKuliah = [];
        $dataMencari = [];

        foreach($jurusans as $jurusan) {
            $labels[] = $jurusan->kode_jurusan; 
            $tracers = \App\Models\TracerStudy::where('tahun_pengisian', $tahunIni)
                ->whereHas('alumni', function($q) use ($jurusan) {
                    $q->where('jurusan_id', $jurusan->id);
                })->get();

            $dataBekerja[] = $tracers->where('status_aktivitas', 'bekerja')->count();
            $dataWirausaha[] = $tracers->where('status_aktivitas', 'wirausaha')->count();
            $dataKuliah[] = $tracers->where('status_aktivitas', 'kuliah')->count();
            $dataMencari[] = $tracers->whereIn('status_aktivitas', ['menganggur', 'lainnya'])->count();
        }
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('jurusanChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [
                        { label: 'Bekerja', data: {!! json_encode($dataBekerja) !!}, backgroundColor: '#10b981', borderRadius: 6 },
                        { label: 'Wirausaha', data: {!! json_encode($dataWirausaha) !!}, backgroundColor: '#f59e0b', borderRadius: 6 },
                        { label: 'Kuliah', data: {!! json_encode($dataKuliah) !!}, backgroundColor: '#3b82f6', borderRadius: 6 },
                        { label: 'Mencari Kerja', data: {!! json_encode($dataMencari) !!}, backgroundColor: '#f43f5e', borderRadius: 6 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        x: { stacked: false },
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        });
    </script>
</div>
@endsection