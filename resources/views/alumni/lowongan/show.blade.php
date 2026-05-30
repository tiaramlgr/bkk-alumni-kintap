@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <a href="{{ route('alumni.lowongan.index') }}" class="text-blue-600 mb-6 inline-block">← Kembali ke Lowongan</a>
    
    <div class="bg-white rounded-3xl shadow p-8">
        <h1 class="text-3xl font-bold">{{ $lowongan->judul_lowongan }}</h1>
        <p class="text-xl text-gray-600 mt-2">{{ $lowongan->nama_perusahaan }} • {{ $lowongan->lokasi }}</p>

        <div class="mt-8 prose">
            <h3>Deskripsi Pekerjaan</h3>
            <p>{{ $lowongan->deskripsi }}</p>

            <h3>Kualifikasi</h3>
            <p>{{ $lowongan->kualifikasi }}</p>
        </div>

        <form action="{{ route('alumni.lowongan.apply', $lowongan->id) }}" method="POST" class="mt-10">
            @csrf
            <textarea name="surat_lamaran" rows="5" 
                      class="w-full border rounded-2xl p-4" 
                      placeholder="Tulis surat lamaran singkat..."></textarea>

            <button type="submit" 
                    class="mt-6 w-full bg-green-600 text-white py-4 rounded-2xl font-semibold hover:bg-green-700">
                Lamar Lowongan Ini
            </button>
        </form>
    </div>
</div>
@endsection