@extends('layouts.admin')

@section('title', 'Detail Riwayat Alumni')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.alumni.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Kelola Alumni
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-start bg-slate-50">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $alumni->user->name ?? 'Tanpa Nama' }}</h2>
                <p class="text-slate-500 font-medium">{{ $alumni->user->email ?? '-' }}</p>
            </div>
            <div>
                @if($alumni->status_akun == 'approved')
                    <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">Disetujui</span>
                @elseif($alumni->status_akun == 'pending')
                    <span class="bg-amber-100 text-amber-700 border border-amber-200 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">Pending</span>
                @else
                    <span class="bg-rose-100 text-rose-700 border border-rose-200 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">Ditolak</span>
                @endif
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
            <div class="space-y-4">
                <h3 class="font-bold text-slate-800 text-base border-b pb-2">Informasi Akademik</h3>
                <div><span class="text-slate-500 block">NISN</span><span class="font-semibold text-slate-900">{{ $alumni->nisn ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">Kompetensi Keahlian</span><span class="font-semibold text-slate-900">{{ $alumni->jurusan->nama_kompetensi ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">Tahun Lulus</span><span class="font-semibold text-slate-900">{{ $alumni->tahun_lulus ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">No. Ijazah</span><span class="font-semibold text-slate-900">{{ $alumni->no_ijazah ?? '-' }}</span></div>
            </div>

            <div class="space-y-4">
                <h3 class="font-bold text-slate-800 text-base border-b pb-2">Data Pribadi</h3>
                <div><span class="text-slate-500 block">Nomor WhatsApp</span><span class="font-semibold text-slate-900">{{ $alumni->no_hp_wa ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">Tempat, Tanggal Lahir</span><span class="font-semibold text-slate-900">{{ $alumni->tempat_lahir ?? '-' }}, {{ optional($alumni->tanggal_lahir)->format('d F Y') ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">Jenis Kelamin</span><span class="font-semibold text-slate-900">{{ ucfirst($alumni->jenis_kelamin) ?? '-' }}</span></div>
                <div><span class="text-slate-500 block">Alamat Domisili</span><span class="font-semibold text-slate-900">{{ $alumni->alamat ?? '-' }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection