@extends('layouts.alumni')

@section('title', 'Dokumen Saya')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Dokumen Saya</h1>

    <!-- Upload Form -->
    <div class="bg-white p-8 rounded-3xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-6">Upload Dokumen Baru</h2>
        <form action="{{ route('alumni.dokumen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Jenis Dokumen</label>
                    <select name="tipe_dokumen" required class="w-full px-4 py-3 border rounded-2xl">
                        <option value="skhu">SKHU</option>
                        <option value="ijazah">Ijazah</option>
                        <option value="transkrip">Transkrip Nilai</option>
                        <option value="sertifikat">Sertifikat Kompetensi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Pilih File</label>
                    <input type="file" name="file" required class="w-full px-4 py-3 border rounded-2xl">
                </div>
            </div>
            <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-4 rounded-2xl font-semibold hover:bg-blue-700">
                Upload Dokumen
            </button>
        </form>
    </div>

    <!-- Daftar Dokumen -->
    <h2 class="text-xl font-semibold mb-4">Daftar Dokumen</h2>
    <div class="bg-white rounded-3xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Jenis Dokumen</th>
                    <th class="px-6 py-4 text-left">Nama File</th>
                    <th class="px-6 py-4 text-left">Tanggal Upload</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokumens as $dokumen)
                <tr class="border-t">
                    <td class="px-6 py-4 font-medium">{{ strtoupper($dokumen->tipe_dokumen) }}</td>
                    <td class="px-6 py-4">{{ $dokumen->nama_file }}</td>
                    <td class="px-6 py-4">{{ $dokumen->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm">Terverifikasi</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada dokumen yang diupload.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection