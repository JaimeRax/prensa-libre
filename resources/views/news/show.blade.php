@extends('layouts.app')
@section('title', 'Detalle de Noticia')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <a class="text-sm underline hover:no-underline text-gray-600" href="{{ url()->previous() }}">
            ← Volver
        </a>

        <div class="mt-6 bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden" id="news-detail">
            <div class="animate-pulse p-6 text-center text-gray-400">Cargando noticia...</div>
        </div>

        <h3 class="mt-10 mb-4 text-lg font-semibold">Noticias recomendadas</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="recommended">
            <div class="animate-pulse text-gray-400 text-sm text-center col-span-full">Cargando recomendaciones...</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const id = {{ $id }};
            const headers = window.JWT ? {
                Authorization: `Bearer ${window.JWT}`
            } : {};

            // Cargar detalle
            try {
                const res = await fetch(`/api/news/${id}`, {
                    headers
                });
                if (!res.ok) throw new Error('Error cargando noticia');
                const n = await res.json();

                document.getElementById('news-detail').innerHTML = `
            <img src="${n.image_url ?? 'https://via.placeholder.com/800x400'}"
                 alt="${n.title}" class="w-full h-72 object-cover">
            <div class="p-6">
                <h1 class="text-3xl font-bold leading-tight">${n.title}</h1>
                <div class="text-sm text-gray-500 mt-2">${new Date(n.published_at).toLocaleDateString()}</div>
                <article class="prose prose-sm max-w-none mt-6 text-gray-800 leading-relaxed">
                    ${n.body}
                </article>
            </div>
        `;
            } catch (e) {
                console.error(e);
                document.getElementById('news-detail').innerHTML = `
            <div class="p-6 text-center text-red-500">No se pudo cargar la noticia.</div>
        `;
            }

            // Cargar recomendadas
            try {
                const rec = await fetch(`/api/news/${id}/recommended`, {
                    headers
                });
                if (!rec.ok) throw new Error('Error cargando recomendadas');
                const items = await rec.json();

                if (!items.length) {
                    document.getElementById('recommended').innerHTML = `
                <div class="text-gray-400 text-sm text-center col-span-full">No hay noticias recomendadas.</div>
            `;
                    return;
                }

                document.getElementById('recommended').innerHTML = items.map(n => `
            <a href="/noticias/${n.id}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 hover:shadow-md transition">
                <img src="${n.image_url ?? 'https://via.placeholder.com/300x200'}"
                     alt="${n.title}" class="h-36 w-full object-cover">
                <div class="p-4">
                    <h4 class="text-sm font-semibold leading-tight line-clamp-2 group-hover:underline">${n.title}</h4>
                    <div class="mt-2 text-xs text-gray-500">${new Date(n.published_at).toLocaleDateString()}</div>
                </div>
            </a>
        `).join('');
            } catch (e) {
                console.error(e);
                document.getElementById('recommended').innerHTML = `
            <div class="text-center text-red-500 col-span-full">Error al cargar las recomendadas.</div>
        `;
            }
        });
    </script>
@endsection
