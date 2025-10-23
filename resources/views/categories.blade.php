@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
    <section class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Categorías</h1>
            <span class="text-sm text-gray-500">Próximamente…</span>
        </div>
        <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-500">Nacionales</div>
            <div class="h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-500">Deportes</div>
            <div class="h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-500">Economía</div>
            <div class="h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-500">Internacional</div>
            <div class="h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-500">Tecnología</div>
        </div>
    </section>
@endsection
