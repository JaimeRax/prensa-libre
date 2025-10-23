@extends('layouts.app')

@section('title', 'Crear noticia')

@section('content')

    @php
        $selected = old('categories', isset($news) ? $news->categories->pluck('id')->all() : []);
    @endphp

    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Crear nueva noticia</h1>

        <form action="{{ route('news.store') }}" class="space-y-6 bg-white p-6 rounded-2xl shadow-sm ring-1 ring-gray-100"
            method="POST">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Categorías</label>
                <select id="categories" multiple name="categories[]">
                    @foreach ($categories as $category)
                        <option @selected(in_array($category->id, old('categories', []))) value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Puedes seleccionar varias.</p>

            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Título</label>
                <input class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900/10"
                    name="title" required type="text" value="{{ old('title') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Descripción breve</label>
                <textarea class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900/10"
                    name="excerpt" rows="2">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Contenido</label>
                <textarea class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900/10"
                    name="body" required rows="5">{{ old('body') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Imagen (URL)</label>
                <input class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900/10"
                    name="image_url" type="url" value="{{ old('image_url') }}">
            </div>

            <div class="flex justify-end">
                <button class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-800 transition">
                    Publicar noticia
                </button>
            </div>
        </form>
    </div>
    <script>
        new TomSelect('#categories', {
            plugins: ['remove_button'],
            maxOptions: null,
            create: false,
            persist: false,
            placeholder: 'Selecciona categorías…',
            render: {
                no_results: function() {
                    return '<div class="py-2 px-3 text-sm text-gray-500">Sin resultados</div>';
                }
            }
        });
    </script>

@endsection
