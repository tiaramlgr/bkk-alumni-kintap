@extends('layouts.admin')

@section('title', 'Edit Draft Siaran WhatsApp')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.siaran.index') }}" class="text-slate-500 hover:text-blue-600 transition flex items-center gap-2 text-sm font-semibold mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siaran
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Edit Draft Siaran WhatsApp</h1>
    </div>

    @php
        $metaData = json_decode($siaran->meta, true) ?? [];
        $currentTarget = $metaData['target_pengiriman'] ?? 'group';
        $selectedAlumnis = $metaData['alumni_ids'] ?? [];
    @endphp

    <form method="POST" action="{{ route('admin.siaran.update', $siaran->id) }}" class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Target Pengiriman <span class="text-red-500">*</span></label>
                <select name="target_pengiriman" id="target_pengiriman" onchange="toggleAlumniList()" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    <option value="group" {{ $currentTarget == 'group' ? 'selected' : '' }}>Grup WhatsApp BKK (1 Pesan Grup)</option>
                    <option value="personal_all" {{ $currentTarget == 'personal_all' ? 'selected' : '' }}>Japri ke Semua Alumni Aktif</option>
                    <option value="personal_selected" {{ $currentTarget == 'personal_selected' ? 'selected' : '' }}>Japri ke Alumni Tertentu (Pilih Manual)</option>
                </select>
            </div>

            <div id="alumni_selection_area" class="{{ $currentTarget == 'personal_selected' ? '' : 'hidden' }} bg-slate-50 border border-slate-200 rounded-xl p-4">
                <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide border-b border-slate-200 pb-2">Pilih Alumni Tujuan <span class="text-red-500">*</span></label>
                <div class="max-h-48 overflow-y-auto space-y-2 pr-2">
                    @forelse($alumnis as $alumni)
                        <label class="flex items-center space-x-3 cursor-pointer hover:bg-slate-100 p-2 rounded-lg transition">
                            <input type="checkbox" name="alumni_ids[]" value="{{ $alumni->id }}" 
                                   {{ in_array($alumni->id, $selectedAlumnis) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800">{{ $alumni->user->name }}</span>
                                <span class="text-xs text-slate-500">{{ $alumni->jurusan->nama_kompetensi ?? '-' }} | {{ $alumni->tahun_lulus }}</span>
                            </div>
                        </label>
                    @empty
                        <p class="text-sm text-slate-500 italic">Belum ada alumni aktif yang berlangganan WhatsApp.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Judul Siaran</label>
                <input type="text" name="judul_siaran" value="{{ old('judul_siaran', $siaran->judul_siaran) }}" required 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Isi Pesan WhatsApp</label>
                <textarea name="template_pesan" rows="8" required 
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">{{ old('template_pesan', $siaran->template_pesan) }}</textarea>
            </div>

            <button type="submit" class="w-full bg-amber-500 text-white py-4 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-amber-500/30 flex justify-center items-center gap-2">
                <i class="fas fa-save"></i> Perbarui Draft Siaran
            </button>
        </div>
    </form>
</div>

<script>
    function toggleAlumniList() {
        const target = document.getElementById('target_pengiriman').value;
        const alumniArea = document.getElementById('alumni_selection_area');
        
        if (target === 'personal_selected') {
            alumniArea.classList.remove('hidden');
        } else {
            alumniArea.classList.add('hidden');
        }
    }
</script>
@endsection