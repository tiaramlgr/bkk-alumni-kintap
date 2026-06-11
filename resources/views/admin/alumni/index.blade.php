@extends('layouts.admin')

@section('title', 'Kelola Data Alumni')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Kelola Alumni</h1>
            <p class="text-sm text-slate-500 mt-1">Pusat data kelulusan, validasi berkas pendaftaran akun, dan manajemen parameter data master</p>
        </div>
        
        <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm">
            <a href="{{ route('admin.jurusan.index') }}" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition flex items-center gap-2">
                <i class="fas fa-graduation-cap text-slate-400"></i> Master Jurusan
            </a>
            <div class="h-4 w-px bg-slate-200"></div>
            <a href="{{ route('admin.kategori-lowongan.index') }}" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition flex items-center gap-2">
                <i class="fas fa-tags text-slate-400"></i> Kategori Lowongan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.alumni.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-wider">Cari Alumni</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, NISN, atau email..." 
                       class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition bg-slate-50/50">
            </div>
            
            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-wider">Filter Jurusan</label>
                <select name="jurusan_id" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 outline-none transition bg-slate-50/50">
                    <option value="">Semua Kompetensi</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_kompetensi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-wider">Status Akun</label>
                <select name="status_akun" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-blue-500 outline-none transition bg-slate-50/50">
                    <option value="">Semua Status</option>
                    <option value="approved" {{ request('status_akun') == 'approved' ? 'selected' : '' }}>Approved (Aktif)</option>
                    <option value="pending" {{ request('status_akun') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="rejected" {{ request('status_akun') == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2 shadow-md shadow-blue-600/10">
                    <i class="fas fa-sliders-h text-xs"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left w-16">No</th>
                    <th class="px-6 py-4 text-left">Nama Lengkap</th>
                    <th class="px-6 py-4 text-left">NISN</th>
                    <th class="px-6 py-4 text-center">Status Akun</th>
                    <th class="px-6 py-4 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($alumnis as $index => $alumni)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4 text-slate-400 font-medium">{{ $alumnis->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $alumni->user->name ?? 'User Tidak Ditemukan' }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $alumni->user->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 font-mono font-medium text-slate-600">{{ $alumni->nisn }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($alumni->status_akun == 'approved')
                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Approved</span>
                        @elseif($alumni->status_akun == 'pending')
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Pending</span>
                        @else
                            <span class="bg-rose-50 text-rose-700 border border-rose-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Rejected</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <a href="{{ route('admin.alumni.show', $alumni->id) }}" class="text-slate-500 hover:text-blue-600 transition" title="Lihat Profil">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.alumni.edit', $alumni->id) }}" class="text-slate-500 hover:text-indigo-600 transition" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.alumni.destroy', $alumni->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini secara permanen?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-rose-600 transition" title="Hapus Data">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Tidak ada data alumni yang memenuhi kriteria pencarian Anda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($alumnis->hasPages())
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            {{ $alumnis->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection