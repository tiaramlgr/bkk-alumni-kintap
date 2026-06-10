@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-2xl p-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-emerald-700">Daftar Perusahaan</h2>
            <p class="text-gray-600 mt-2">BKK SMK Negeri Kintap</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('perusahaan.register') }}">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Nama Penanggung Jawab</label>
                    <input type="text" name="name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Email Perusahaan</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">No HP / WhatsApp</label>
                    <input type="text" name="no_hp_wa" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-emerald-500">
                </div>

                <button type="submit" 
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold text-lg transition">
                    DAFTAR PERUSAHAAN
                </button>
            </div>
        </form>

        <p class="text-center mt-6 text-sm text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('perusahaan.login') }}" class="text-emerald-600 hover:underline">Login di sini</a>
        </p>
    </div>
</div>
@endsection