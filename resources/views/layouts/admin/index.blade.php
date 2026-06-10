@extends('layouts.admin')

@section('title', 'Kelola Users')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Kelola Users</h1>
    <a href="{{ route('admin.users.create') }}"
       class="bg-blue-600 text-white px-6 py-3 rounded-2xl hover:bg-blue-700 transition">
        + Tambah User
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-2xl mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-2xl mb-4">{{ session('error') }}</div>
@endif

<div class="bg-white rounded-3xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-4 text-left">Nama</th>
                <th class="px-6 py-4 text-left">Email</th>
                <th class="px-6 py-4 text-left">Role</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Tanggal Daftar</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($user->role === 'admin') bg-purple-100 text-purple-700
                        @elseif($user->role === 'alumni') bg-blue-100 text-blue-700
                        @elseif($user->role === 'perusahaan') bg-orange-100 text-orange-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    @if($user->is_active)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center text-sm text-gray-500">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('admin.users.show', $user->id) }}"
                       class="text-blue-600 hover:underline text-sm">Detail</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                       class="text-yellow-600 hover:underline text-sm">Edit</a>

                    <form action="{{ route('admin.users.toggle-active', $user->id) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="{{ $user->is_active ? 'text-orange-600' : 'text-green-600' }} hover:underline text-sm">
                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>

                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-12 text-gray-500">Belum ada data user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection