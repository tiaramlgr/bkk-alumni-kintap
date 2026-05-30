@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h1>
    <p class="text-gray-600">Role: {{ auth()->user()->role }}</p>
</div>
@endsection