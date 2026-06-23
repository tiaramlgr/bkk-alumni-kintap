@extends('layouts.admin')

@section('title', 'Whitelist NISN Alumni SMKN Kintap')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Whitelist NISN Alumni</h1>
            <p class="text-slate-500 text-sm mt-1">
                Hanya NISN yang terdaftar di sini yang diizinkan mendaftar ke portal alumni SMKN Kintap.
            </p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('admin.whitelist.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition">
                <i class="fas fa-plus"></i> Tambah NISN
            </a>
            <button onclick="document.getElementById('modal-import').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition">
                <i class="fas fa-file-csv"></i> Import CSV
            </button>
        </div>
    </div>

    {{-- Alert sukses/error --}}
    @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl flex items-start gap-2">
            <i class="fas fa-check-circle mt-0.5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if ($errors->has('delete'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl flex items-start gap-2">
            <i class="fas fa-exclamation-triangle mt-0.5"></i>
            <span>{{ $errors->first('delete') }}</span>
        </div>
    @endif

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('admin.whitelist.index') }}" class="mb-4 flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari NISN, nama, atau jurusan..."
               class="flex-1 min-w-[220px] px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
        <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-600 outline-none">
            <option value="">Semua Status</option>
            <option value="belum" @selected(request('status') === 'belum')>Belum Daftar</option>
            <option value="sudah" @selected(request('status') === 'sudah')>Sudah Daftar</option>
        </select>
        <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-sm font-semibold hover:bg-slate-900 transition">
            <i class="fas fa-search"></i> Cari
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.whitelist.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 hover:bg-slate-50 transition">Reset</a>
        @endif
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">NISN</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Nama (Arsip Sekolah)</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Tahun Lulus</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Jurusan</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Status</th>
                    <th class="text-right px-4 py-3 font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($whitelists as $item)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-mono font-semibold text-slate-800">{{ $item->nisn }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $item->nama_lengkap ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $item->tahun_lulus ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $item->jurusan ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if ($item->sudah_daftar)
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                    <i class="fas fa-check-circle text-[10px]"></i> Sudah Daftar
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                    <i class="fas fa-clock text-[10px]"></i> Belum Daftar
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                @if ($item->sudah_daftar)
                                    <form method="POST" action="{{ route('admin.whitelist.reset', $item) }}"
                                          onsubmit="return confirm('Reset status NISN ini agar alumni bisa daftar ulang?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-1.5 rounded-lg transition"
                                                title="Reset agar bisa daftar ulang">
                                            <i class="fas fa-redo"></i> Reset
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.whitelist.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus NISN {{ $item->nisn }} dari whitelist?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                            <i class="fas fa-shield-alt text-3xl mb-3 block text-slate-200"></i>
                            Belum ada data whitelist NISN. Tambahkan NISN atau import dari CSV.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $whitelists->links() }}
    </div>
</div>

{{-- Modal Import CSV --}}
<div id="modal-import" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-slate-800 text-lg">Import NISN dari CSV</h3>
            <button onclick="document.getElementById('modal-import').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-4 text-sm text-blue-700">
            <strong>Format CSV:</strong> Baris pertama adalah header.<br>
            Kolom: <code class="bg-blue-100 px-1 rounded">nisn, nama_lengkap, tahun_lulus, jurusan</code>
        </div>

        <form method="POST" action="{{ route('admin.whitelist.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih File CSV</label>
                <input type="file" name="file_csv" accept=".csv,.txt" required
                       class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-slate-100 file:font-semibold hover:file:bg-slate-200">
            </div>
            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                    <i class="fas fa-upload mr-1"></i> Import Sekarang
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-import').classList.add('hidden')"
                        class="flex-1 border border-slate-200 text-slate-600 font-semibold py-2.5 rounded-xl text-sm hover:bg-slate-50 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection