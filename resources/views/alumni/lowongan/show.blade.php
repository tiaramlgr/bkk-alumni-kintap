@extends('layouts.alumni')

@section('title', $lowongan->judul_lowongan ?? 'Detail Lowongan')

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('alumni.lowongan.index') }}" class="inline-flex items-center gap-2 text-blue-600 mb-6 hover:underline">
        ← Kembali ke Daftar Lowongan
    </a>

    <div class="bg-white rounded-3xl shadow-lg p-8">
        @if($lowongan->foto)
            <img src="{{ asset('storage/' . $lowongan->foto) }}" class="w-full h-80 object-cover rounded-2xl mb-8" alt="">
        @endif

        <h1 class="text-3xl font-bold">{{ $lowongan->judul_lowongan }}</h1>
        <p class="text-2xl text-gray-700 mt-2">{{ $lowongan->nama_perusahaan }}</p>

        <div class="flex gap-6 mt-6 text-sm">
            <div><strong>Lokasi:</strong> {{ $lowongan->lokasi }}</div>
            <div><strong>Tipe:</strong> {{ ucfirst(str_replace('_', ' ', $lowongan->tipe_pekerjaan)) }}</div>
            <div><strong>Deadline:</strong> {{ $lowongan->deadline->format('d M Y') }}</div>
        </div>

        <div class="mt-10">
            <h3 class="font-semibold text-lg mb-3">Deskripsi Pekerjaan</h3>
            <p class="text-gray-700 leading-relaxed">{{ $lowongan->deskripsi }}</p>
        </div>

        <div class="mt-8">
            <h3 class="font-semibold text-lg mb-3">Kualifikasi</h3>
            <p class="text-gray-700 whitespace-pre-line">{{ $lowongan->kualifikasi }}</p>
        </div>

        <!-- Form Lamar -->
        <form method="POST" action="{{ route('alumni.lowongan.apply', $lowongan->id) }}" enctype="multipart/form-data" class="mt-12 bg-gray-50 p-8 rounded-3xl">
            @csrf
            <h3 class="font-semibold mb-6 text-xl">Ajukan Lamaran Sekarang</h3>

            <div class="mb-6">
                <label class="block font-medium mb-2">Surat Lamaran *</label>
                <textarea name="surat_lamaran" rows="6" required class="w-full px-5 py-4 border rounded-2xl" placeholder="Tuliskan motivasi dan surat lamaran Anda..."></textarea>
            </div>

            <div class="mb-8">
                <label class="block font-medium mb-2">Upload CV (PDF/DOC) - Opsional</label>
                <input type="file" name="file_cv" accept=".pdf,.doc,.docx" class="w-full px-5 py-4 border rounded-2xl">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-semibold text-lg transition">
                KIRIM LAMARAN SEKARANG
            </button>
        </form>
    </div>
</div>
@endsection