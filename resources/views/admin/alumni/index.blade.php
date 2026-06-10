@extends('layouts.admin')

@section('title', 'Kelola Alumni')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Kelola Alumni</h1>
        <p class="text-sm text-slate-500 mt-1">Manajemen data lulusan dan verifikasi akun pendaftar</p>
    </div>
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
                <th class="px-6 py-4 text-left">Nama</th>
                <th class="px-6 py-4 text-left">NISN</th>
                <th class="px-6 py-4 text-left">Jurusan</th>
                <th class="px-6 py-4 text-center">Tahun Lulus</th>
                <th class="px-6 py-4 text-center">Status Akun</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
            @forelse($alumnis as $alumni)
            <tr class="hover:bg-slate-50/80 transition">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-900">{{ $alumni->user->name ?? '-' }}</div>
                    <div class="text-xs text-slate-500">{{ $alumni->user->email ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 font-mono text-slate-600">{{ $alumni->nisn ?? '-' }}</td>
                <td class="px-6 py-4 text-slate-700">{{ $alumni->jurusan->nama_kompetensi ?? '-' }}</td>
                <td class="px-6 py-4 text-center font-semibold">{{ $alumni->tahun_lulus ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    @if($alumni->status_akun == 'approved')
                        <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Disetujui</span>
                    @elseif($alumni->status_akun == 'pending')
                        <span class="bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Pending</span>
                    @else
                        <span class="bg-rose-100 text-rose-700 border border-rose-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Ditolak</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-3">
                        
                        <a href="{{ route('admin.alumni.show', $alumni->id) }}" class="text-slate-500 hover:text-blue-600 transition" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.alumni.edit', $alumni->id) }}" class="text-slate-500 hover:text-indigo-600 transition" title="Edit Data">
                            <i class="fas fa-edit"></i>
                        </a>

                        @if($alumni->status_akun == 'pending')
                            <form action="{{ route('admin.alumni.approve', $alumni->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui akun alumni ini?');">
                                @csrf
                                <button type="submit" class="text-slate-500 hover:text-emerald-600 transition" title="Setujui Pendaftaran">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.alumni.reject', $alumni->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak akun alumni ini?');">
                                @csrf
                                <input type="hidden" name="catatan" value="Data tidak valid/tidak ditemukan.">
                                <button type="submit" class="text-slate-500 hover:text-amber-600 transition" title="Tolak Pendaftaran">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.alumni.destroy', $alumni->id) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Menghapus data ini juga akan menghapus akun user alumni tersebut. Anda yakin?');">
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
                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                    <i class="fas fa-users-slash text-4xl mb-3 text-slate-200 block"></i>
                    Belum ada data pendaftar alumni di sistem.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($alumnis->hasPages())
    <div class="p-6 bg-slate-50 border-t border-slate-100">
        {{ $alumnis->links() }}
    </div>
    @endif
</div>
@endsection