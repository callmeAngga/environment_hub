@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <div class="mb-4">
            <i class="fas fa-hard-hat text-6xl text-yellow-500"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Halaman {{ $title ?? 'Menu' }}</h2>
        <p class="text-gray-600">Fitur ini sedang dalam tahap pengembangan (Under Construction).</p>
        
        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection