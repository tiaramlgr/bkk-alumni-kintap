@extends('layouts.admin')

@section('title', 'Kelola Tracer Study')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Data Tracer Study</h1>
        <p class="text-slate-500 mt-1">Pantau karir dan aktivitas alumni setelah lulus.</p>
    </div>
    <a href="{{ route('admin.tracer.create') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Input Data Manual
    </a>
</div>

@if(session('success'))
<div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-600 text-sm uppercase tracking-wider border-b border-slate-200">
                    <th class="p-4 font-semibold">Tahun</th>
                    <th class="p-4 font-semibold">Nama Alumni</th>
                    <th class="p-4 font-semibold">Status Aktivitas</th>
                    <th class="p-4 font-semibold">Instansi / Usaha</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tracers as $tracer)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 text-slate-800 font-medium">{{ $tracer->tahun_pengisian }}</td>
                    <td class="p-4">
                        <div class="font-semibold text-slate-800">{{ $tracer->alumni->user->name ?? 'User Terhapus' }}</div>
                        <div class="text-xs text-slate-500">Lulusan: {{ $tracer->alumni->tahun_lulus ?? '-' }}</div>
                    </td>
                    <td class="p-4">
                        @if($tracer->status_aktivitas == 'bekerja')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Bekerja</span>
                        @elseif($tracer->status_aktivitas == 'wirausaha')
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Wirausaha</span>
                        @elseif($tracer->status_aktivitas == 'kuliah')
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Kuliah</span>
                        @else
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $tracer->status_aktivitas }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-slate-600">
                        {{ $tracer->nama_instansi ?? $tracer->keterangan_status ?? '-' }}
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.tracer.show', $tracer->id) }}" class="p-2 bg-slate-100 text-slate-600 hover:text-blue-600 rounded-lg transition" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.tracer.edit', $tracer->id) }}" class="p-2 bg-slate-100 text-slate-600 hover:text-emerald-600 rounded-lg transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.tracer.destroy', $tracer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-slate-100 text-slate-600 hover:text-red-600 rounded-lg transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">Belum ada data Tracer Study yang diisi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tracers->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $tracers->links() }}
        </div>
    @endif
</div>
@endsection