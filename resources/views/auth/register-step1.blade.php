@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-2">Daftar Akun</h2>
        <p class="text-gray-600 text-center mb-8">Langkah 1 dari 3</p>

        <form method="POST" action="{{ route('register.step1') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 border rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border rounded-2xl focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-4 py-3 border rounded-2xl focus:outline-none focus:border-blue-500">
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-4 rounded-2xl font-semibold hover:bg-blue-700 transition">
                    Lanjut ke Langkah 2
                </button>
            </div>
        </form>
    </div>
</div>
@endsection