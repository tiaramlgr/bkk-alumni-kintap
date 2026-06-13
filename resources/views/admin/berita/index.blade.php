@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Data Berita BKK</h1>
        <a href="{{ route('admin.berita.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl hover:bg-blue-700 font-semibold shadow-sm">
            + Tambah Berita
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-6 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold text-slate-600">Foto</th>
                    <th class="px-6 py-4 text-left font-semibold text-slate-600">Judul Berita</th>
                    <th class="px-6 py-4 text-left font-semibold text-slate-600">Status</th>
                    <th class="px-6 py-4 text-center font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($beritas as $item)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" class="h-16 w-24 object-cover rounded-xl border border-slate-200" alt="Foto">
                        @else
                            <div class="h-16 w-24 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs">No Image</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $item->judul }}</div>
                        <div class="text-xs text-slate-500 mt-1"><i class="fas fa-user mr-1"></i> {{ $item->admin->name ?? 'Admin' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->status == 'published')
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Published</span>
                        @else
                            <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.berita.show', $item->id) }}" class="text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-3 py-2 rounded-lg" title="Lihat"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-2 rounded-lg" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 bg-rose-50 px-3 py-2 rounded-lg" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-medium">Belum ada berita yang dipublikasikan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $beritas->links() }}
    </div>
</div>
@endsection