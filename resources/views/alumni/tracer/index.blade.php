@extends('layouts.alumni')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-slate-800">Tracer Study Alumni</h1>

    @if($tracer)
        <div class="bg-white shadow-sm border border-slate-100 rounded-2xl p-8">
            <div class="mb-4">
                <span class="text-sm text-slate-500">Status Pekerjaan:</span>
                <p class="text-lg font-bold text-slate-800 uppercase">{{ $tracer->status_aktivitas }}</p>
            </div>
            <div class="flex gap-4 mt-6">
                <a href="{{ route('alumni.tracer.edit') }}" class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition">Edit Data Tracer</a>
            </div>
        </div>
    @else
        <div class="bg-white p-10 rounded-2xl border border-slate-200 text-center">
            <p class="text-slate-600 mb-6">Anda belum mengisi data Tracer Study.</p>
            <a href="{{ route('alumni.tracer.create') }}" class="bg-emerald-600 text-white px-8 py-3 rounded-xl hover:bg-emerald-700 transition font-bold">Isi Sekarang</a>
        </div>
    @endif
</div>
@endsection