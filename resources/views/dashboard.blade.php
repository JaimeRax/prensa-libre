@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Panel de administración</h1>

        <div class="bg-white p-6 rounded-xl shadow-sm ring-1 ring-gray-100">
            <p class="text-gray-700 mb-4">
                Bienvenido, <strong>{{ auth()->user()->name }}</strong>
            </p>

            <a class="inline-block bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition"
                href="{{ route('news.create') }}">
                Crear nueva noticia
            </a>
        </div>
    </div>
@endsection
