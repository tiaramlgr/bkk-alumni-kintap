@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-2">Lengkapi Data Diri</h2>
        <p class="text-gray-600 text-center mb-8">Langkah 2 dari 3</p>

        <form method="POST" action="{{ route('register.step2') }}">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                        <input type="text" name="nisn" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp_wa" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                    <select name="jurusan_id" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach(\App\Models\Jurusan::where('is_active', true)->get() as $jurusan)
                            <option value="{{ $jurusan->id }}">
                                {{ $jurusan->nama_kompetensi }} ({{ $jurusan->kode_jurusan }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" 
                    class="mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold transition">
                Daftar & Lanjut Verifikasi
            </button>
        </form>
    </div>
</div>
@endsection