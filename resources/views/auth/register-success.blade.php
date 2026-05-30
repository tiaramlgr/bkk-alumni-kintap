@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-green-600 mb-4">✅ Registrasi Berhasil!</h1>
        <p class="text-xl text-gray-600 mb-8">Silakan cek email Anda untuk verifikasi.</p>
        <a href="/login" class="bg-blue-600 text-white px-8 py-4 rounded-2xl text-lg">
            Masuk ke Akun
        </a>
    </div>
</div>
@endsection