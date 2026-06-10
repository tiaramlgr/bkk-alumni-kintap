@extends('layouts.admin')

@section('title', 'Siaran WhatsApp')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold">Siaran WhatsApp</h1>
    <a href="{{ route('admin.siaran.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-2xl hover:bg-green-700">
        + Buat Siaran Baru
    </a>
</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-4 text-left">Judul Siaran</th>
                <th class="px-6 py-4 text-left">Jenis</th>
                <th class="px-6 py-4 text-left">Tanggal</th>
                <th class="px-6 py-4 text-center">Penerima</th>
                <th class="px-6 py-4 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siarans as $siaran)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $siaran->judul_siaran }}</td>
                <td class="px-6 py-4">{{ ucfirst($siaran->jenis_siaran) }}</td>
                <td class="px-6 py-4">{{ $siaran->created_at->format('d M Y H:i') }}</td>
                <td class="px-6 py-4 text-center">{{ $siaran->total_penerima }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-4 py-1 rounded-full text-sm 
                        {{ $siaran->status_batch == 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($siaran->status_batch) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada siaran WhatsApp.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection