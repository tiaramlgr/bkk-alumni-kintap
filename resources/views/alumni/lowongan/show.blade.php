@extends('layouts.alumni')

@section('title', $lowongan->judul_lowongan ?? 'Detail Lowongan')

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('alumni.lowongan.index') }}" class="inline-flex items-center gap-2 text-blue-600 mb-6 hover:underline font-medium">
        ← Kembali ke Daftar Lowongan
    </a>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl font-medium">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-lg p-8">
        @if($lowongan->foto)
            <img src="{{ asset('storage/' . $lowongan->foto) }}" class="w-full h-80 object-cover rounded-2xl mb-8" alt="Poster Lowongan">
        @endif

        <h1 class="text-3xl font-bold text-slate-800">{{ $lowongan->judul_lowongan }}</h1>
        <p class="text-2xl text-slate-600 mt-2">{{ $lowongan->nama_perusahaan }}</p>

        <div class="flex flex-wrap gap-6 mt-6 text-sm bg-slate-50 p-4 rounded-xl border border-slate-100">
            <div><strong class="text-slate-700">Lokasi:</strong> <span class="text-slate-600">{{ $lowongan->lokasi }}</span></div>
            <div><strong class="text-slate-700">Tipe:</strong> <span class="text-slate-600">{{ ucfirst(str_replace('_', ' ', $lowongan->tipe_pekerjaan)) }}</span></div>
            <div><strong class="text-slate-700">Batas Akhir:</strong> <span class="text-slate-600">{{ $lowongan->deadline->format('d M Y') }}</span></div>
        </div>

        <div class="mt-10">
            <h3 class="font-semibold text-xl mb-3 text-slate-800">Deskripsi Pekerjaan</h3>
            <p class="text-slate-600 leading-relaxed">{{ $lowongan->deskripsi }}</p>
        </div>

        <div class="mt-8">
            <h3 class="font-semibold text-xl mb-3 text-slate-800">Kualifikasi</h3>
            <p class="text-slate-600 whitespace-pre-line leading-relaxed">{{ $lowongan->kualifikasi }}</p>
        </div>

        @if($sudahMelamar)
            <div class="mt-12 bg-emerald-50 border border-emerald-200 text-emerald-800 p-8 rounded-3xl text-center shadow-sm">
                <i class="fas fa-check-circle text-6xl mb-4 text-emerald-500"></i>
                <h3 class="font-bold text-2xl">Anda Sudah Mengirim Lamaran!</h3>
                <p class="mt-2 text-emerald-700 text-lg">Data Anda telah masuk ke sistem dan menunggu *review* oleh Admin/Perusahaan.</p>
                <a href="{{ route('alumni.lamaran.index') }}" class="mt-6 inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-md hover:-translate-y-1">
                    Cek Riwayat Lamaran
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('alumni.lowongan.apply', $lowongan->id) }}" enctype="multipart/form-data" class="mt-12 bg-slate-50 p-8 rounded-3xl border border-slate-100">
                @csrf
                <h3 class="font-bold mb-6 text-2xl text-slate-800">Ajukan Lamaran Sekarang</h3>

                <div class="mb-6">
                    <label class="block font-semibold mb-2 text-slate-700">Motivasi / Surat Lamaran Singkat <span class="text-red-500">*</span></label>
                    <textarea name="surat_lamaran" rows="6" required class="w-full px-5 py-4 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Jelaskan secara singkat mengapa Anda adalah kandidat yang tepat untuk posisi ini..."></textarea>
                </div>

                <div class="mb-8">
                    <label class="block font-semibold mb-2 text-slate-700">Upload CV (PDF/DOC) <span class="text-slate-400 font-normal">- Opsional namun disarankan</span></label>
                    <input type="file" name="file_cv" accept=".pdf,.doc,.docx" class="w-full px-5 py-4 border border-slate-300 rounded-2xl bg-white focus:ring-2 focus:ring-blue-500 outline-none transition cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-bold text-lg transition shadow-lg shadow-blue-500/30 flex justify-center items-center gap-3 hover:-translate-y-1">
                    <i class="fas fa-paper-plane"></i> KIRIM LAMARAN SEKARANG
                </button>
            </form>
        @endif
    </div>
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-xl">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection