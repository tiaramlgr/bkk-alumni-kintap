@extends('layouts.admin')

@section('title', 'Kandidat Pelamar')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.lowongan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Lowongan
    </a>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-6">
        <h2 class="text-xl font-bold text-slate-800">Daftar Pelamar: {{ $lowongan->judul_lowongan }}</h2>
        <p class="text-slate-500 text-sm">{{ $lowongan->nama_perusahaan }}</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl mb-6 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left">Nama Kandidat</th>
                    <th class="px-6 py-4 text-left">Jurusan & Lulus</th>
                    <th class="px-6 py-4 text-center">Tanggal Melamar</th>
                    <th class="px-6 py-4 text-center">Berkas CV</th>
                    <th class="px-6 py-4 text-center">Aksi / Keputusan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($lamarans as $lamaran)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $lamaran->alumni->user->name ?? 'Anonim' }}</div>
                        <div class="text-xs text-slate-400">{{ $lamaran->alumni->user->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-700">{{ $lamaran->alumni->jurusan->kode_jurusan ?? '-' }}</div>
                        <div class="text-xs text-slate-400">Angkatan {{ $lamaran->alumni->tahun_lulus ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ $lamaran->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($lamaran->file_cv)
                            <a href="{{ Storage::url($lamaran->file_cv) }}" target="_blank" class="text-blue-600 hover:underline flex items-center justify-center gap-1">
                                <i class="fas fa-file-pdf"></i> Lihat CV
                            </a>
                        @else
                            <span class="text-slate-400 italic">Tidak ada CV</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.lamaran.status', $lamaran->id) }}" method="POST" class="flex flex-col gap-2 items-center">
                            @csrf
                            <select name="status_lamaran" class="text-xs border border-slate-200 rounded-lg px-2 py-1 focus:outline-none focus:border-blue-500" onchange="this.form.submit()">
                                <option value="pending" {{ $lamaran->status_lamaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="review" {{ $lamaran->status_lamaran == 'review' ? 'selected' : '' }}>Direview</option>
                                <option value="diterima" {{ $lamaran->status_lamaran == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ $lamaran->status_lamaran == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada alumni yang melamar posisi ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($lamarans->hasPages())
        <div class="p-4 bg-slate-50 border-t border-slate-100">
            {{ $lamarans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection