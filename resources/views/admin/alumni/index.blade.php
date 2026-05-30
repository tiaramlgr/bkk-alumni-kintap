@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Manajemen Alumni</h1>

    <h2 class="text-xl font-semibold mb-4 text-orange-600">Pending Approval ({{ $pending->count() }})</h2>
    <div class="bg-white rounded-2xl shadow overflow-hidden mb-10">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">NISN</th>
                    <th class="px-6 py-4 text-left">Jurusan</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pending as $alumni)
                <tr class="border-t">
                    <td class="px-6 py-4">{{ $alumni->user->name }}</td>
                    <td class="px-6 py-4">{{ $alumni->nisn }}</td>
                    <td class="px-6 py-4">{{ $alumni->jurusan->nama_program ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $alumni->user->email }}</td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.alumni.approve', $alumni->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm">Approve</button>
                        </form>
                        <form action="{{ route('admin.alumni.reject', $alumni->id) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl text-sm">Tolak</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="/admin/dashboard" class="text-blue-600 hover:underline">← Kembali ke Dashboard</a>
</div>
@endsection