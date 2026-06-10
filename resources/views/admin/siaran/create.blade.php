@extends('layouts.admin')

@section('title', 'Buat Siaran WhatsApp')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Buat Siaran WhatsApp Baru</h1>

    <form method="POST" action="{{ route('admin.siaran.store') }}" class="bg-white p-8 rounded-3xl shadow">
        @csrf
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">Judul Siaran</label>
                <input type="text" name="judul_siaran" required 
                       class="w-full px-4 py-3 border rounded-2xl">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Isi Pesan</label>
                <textarea name="template_pesan" rows="8" required 
                          class="w-full px-4 py-3 border rounded-2xl"></textarea>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-2xl font-semibold hover:bg-green-700">
                Kirim Siaran WhatsApp
            </button>
        </div>
    </form>
</div>
@endsection