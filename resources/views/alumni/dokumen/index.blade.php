@extends('layouts.alumni')

@section('title', 'Berkas Resmi')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-8 border-b border-slate-100 pb-4">
        <h1 class="text-3xl font-bold text-slate-900">Berkas Resmi Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Arsip dokumen SKHU/Ijazah yang diterbitkan oleh Admin/Pihak Sekolah.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4 text-left w-16">No</th>
                    <th class="px-6 py-4 text-left">Jenis Dokumen</th>
                    <th class="px-6 py-4 text-left">Nama File</th>
                    <th class="px-6 py-4 text-center">Tahun</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($dokumens as $index => $dokumen)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-center">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-bold text-slate-900 uppercase">{{ $dokumen->tipe_dokumen }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $dokumen->nama_file }}</td>
                    <td class="px-6 py-4 text-center">{{ $dokumen->tahun_dokumen }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ asset('storage/' . $dokumen->path_file) }}" download="{{ $dokumen->nama_file }}" class="bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 w-max mx-auto">
                            <i class="fas fa-download"></i> Unduh
                        </a>
                    </td>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                        Admin belum mengunggah dokumen apapun untuk Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection