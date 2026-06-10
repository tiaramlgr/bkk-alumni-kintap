@extends('layouts.alumni')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Edit Profil Saya</h1>

    <div class="bg-white rounded-3xl shadow p-8">
        <form action="{{ route('alumni.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled 
                           class="w-full px-4 py-3 border rounded-2xl bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">NISN</label>
                    <input type="text" value="{{ $alumni->nisn ?? '-' }}" disabled 
                           class="w-full px-4 py-3 border rounded-2xl bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" value="{{ $alumni->tahun_lulus }}" 
                           class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-2">Alamat</label>
                    <textarea name="alamat" rows="3" 
                              class="w-full px-4 py-3 border rounded-2xl">{{ $alumni->alamat }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">No HP / WhatsApp</label>
                    <input type="text" name="no_hp_wa" value="{{ $alumni->no_hp_wa }}" 
                           class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div>
                    <label class="flex items-center gap-3 mt-8">
                        <input type="checkbox" name="is_subscribe_wa" 
                               {{ $alumni->is_subscribe_wa ? 'checked' : '' }} class="w-5 h-5">
                        <span>Saya ingin menerima informasi lowongan via WhatsApp</span>
                    </label>
                </div>
            </div>

            <button type="submit" 
                    class="mt-10 w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold">
                Simpan Perubahan Profil
            </button>
        </form>
    </div>
</div>
@endsection