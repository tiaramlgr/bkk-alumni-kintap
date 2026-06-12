@extends('layouts.admin')

@section('title', 'Kelola Perusahaan Mitra')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Mitra Perusahaan</h1>
            <p class="text-slate-500 mt-1">Kelola data perusahaan yang bekerja sama dengan BKK.</p>
        </div>
        </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider border-b border-slate-200">
                        <th class="p-5 font-semibold">Nama Perusahaan</th>
                        <th class="p-5 font-semibold">Sektor</th>
                        <th class="p-5 font-semibold">Kontak</th>
                        <th class="p-5 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @forelse($perusahaans as $pt)
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                        <td class="p-5 font-bold text-slate-800">{{ $pt->nama_perusahaan }}</td>
                        <td class="p-5">{{ $pt->sektor_industri }}</td>
                        <td class="p-5">
                            <div class="text-sm">
                                <div><i class="fas fa-envelope text-slate-400 w-5"></i> {{ $pt->email_kantor ?? '-' }}</div>
                                
                                <div class="mt-1"><i class="fas fa-phone text-slate-400 w-5"></i> {{ $pt->no_hp_wa ?? '-' }}</div>
                            </div>
                        </td>
                        <td class="p-5 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.perusahaan.edit', $pt->id) }}" class="p-2 bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.perusahaan.destroy', $pt->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus perusahaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-100 text-rose-600 rounded-lg hover:bg-rose-200 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">
                            Belum ada data perusahaan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $perusahaans->links() }}
        </div>
    </div>
</div>
@endsection