@extends('layouts.admin')

@section('title', 'Siaran WhatsApp')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font bold text-slate-800">Siaran WhatsApp</h1>
            <p class="text-sm text-slate-500 mt-1">Kirim pesan massal (broadcast) ke seluruh alumni.</p>
        </div>
        
        <a href="{{ route('admin.siaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold flex items-center gap-2 transition shadow-lg">
            <i class="fas fa-plus"></i> Buat Siaran Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-100 border border-rose-400 text-rose-800 px-4 py-3 rounded-2xl font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left">Judul Siaran</th>
                    <th class="px-6 py-4 text-left">Tanggal Dibuat</th>
                    <th class="px-6 py-4 text-center">Penerima</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($siarans as $siaran)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4 font-bold text-slate-900">{{ $siaran->judul_siaran }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $siaran->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 text-center font-mono font-medium text-slate-600">{{ $siaran->total_penerima }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($siaran->status_batch == 'selesai')
                            <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold uppercase">Selesai</span>
                        @elseif($siaran->status_batch == 'proses')
                            <span class="bg-blue-100 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-bold uppercase">Proses</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-bold uppercase">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.siaran.show', $siaran->id) }}" class="bg-slate-100 text-slate-600 w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition" title="Lihat Detail">
                                <i class="fas fa-eye text-xs"></i>
                            </a>

                            @if($siaran->status_batch == 'pending' || $siaran->status_batch == 'draft')
                                <a href="{{ route('admin.siaran.edit', $siaran->id) }}" class="bg-amber-100 text-amber-600 w-8 h-8 rounded-full hover:bg-amber-200 flex items-center justify-center transition" title="Edit Draft">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>

                                <form action="{{ route('admin.siaran.send', $siaran->id) }}" method="POST" class="inline" onsubmit="return confirm('Kirim broadcast ini ke Grup sekarang?')">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white w-8 h-8 rounded-full hover:bg-blue-700 flex items-center justify-center transition shadow-md shadow-blue-500/30" title="Kirim Sekarang">
                                        <i class="fas fa-paper-plane text-xs"></i>
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.siaran.destroy', $siaran->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus riwayat siaran ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-100 text-rose-600 w-8 h-8 rounded-full hover:bg-rose-200 flex items-center justify-center transition" title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada riwayat siaran WhatsApp.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($siarans->hasPages())
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            {{ $siarans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection