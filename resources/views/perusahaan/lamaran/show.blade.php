@extends('layouts.perusahaan')

@section('title', 'Detail Pelamar')

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('perusahaan.lamaran.index') }}" class="inline-flex items-center gap-2 text-emerald-600 mb-6">
        ← Kembali ke Data Pelamar
    </a>

    <div class="bg-white rounded-3xl shadow p-8">
        <h1 class="text-3xl font-bold">{{ $lamaran->alumni->user->name ?? 'Pelamar' }}</h1>
        <p class="text-gray-600">{{ $lamaran->lowongan->judul_lowongan }}</p>

        <div class="mt-10 grid grid-cols-2 gap-8">
            <div>
                <h3 class="font-semibold mb-4">Surat Lamaran</h3>
                <div class="bg-gray-50 p-6 rounded-2xl text-gray-700 whitespace-pre-line">
                    {{ $lamaran->surat_lamaran }}
                </div>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Dokumen Pelamar</h3>
                @if($lamaran->file_cv)
                    <a href="{{ asset('storage/' . $lamaran->file_cv) }}" target="_blank" class="block text-blue-600 hover:underline">
                        📄 Download CV
                    </a>
                @endif
            </div>
        </div>

        <!-- Form Konfirmasi -->
        <form action="{{ route('perusahaan.lamaran.status', $lamaran->id) }}" method="POST" class="mt-12 bg-gray-50 p-8 rounded-3xl">
            @csrf
            @method('PUT')

            <label class="block text-sm font-medium mb-3">Update Status Lamaran</label>
            <select name="status_lamaran" class="text-sm border-gray-300 rounded-xl px-3 py-2 outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                <option value="pending" {{ $lamaran->status_lamaran == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                <option value="direview" {{ $lamaran->status_lamaran == 'direview' ? 'selected' : '' }}>Direview</option>
                <option value="diterima" {{ $lamaran->status_lamaran == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ $lamaran->status_lamaran == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            
            <label class="block text-sm font-medium mb-3">Catatan untuk Pelamar</label>
            <textarea name="catatan_admin" rows="4" class="w-full px-5 py-4 border rounded-2xl">{{ $lamaran->catatan_admin }}</textarea>

            <button type="submit" class="mt-8 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-5 rounded-2xl font-semibold text-lg">
                SIMPAN STATUS LAMARAN
            </button>
        </form>
    </div>
</div>
@endsection