@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-10">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-emerald-700">Portal Perusahaan</h2>
            <p class="text-gray-600 mt-2">BKK SMK Negeri Kintap</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6 text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('perusahaan.login') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Email Perusahaan</label>
                    <input type="email" name="email" required 
                           class="w-full px-5 py-4 border rounded-2xl focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-5 py-4 border rounded-2xl focus:border-emerald-500">
                </div>

                <button type="submit" 
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold text-lg">
                    LOGIN PERUSAHAAN
                </button>
            </div>
        </form>

        <p class="text-center mt-8 text-sm">
            Belum terdaftar? 
            <a href="{{ route('perusahaan.register') }}" class="text-emerald-600 hover:underline font-medium">Daftar Perusahaan</a>
        </p>
    </div>
</div>
@endsection