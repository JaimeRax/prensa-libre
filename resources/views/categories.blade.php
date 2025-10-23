@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
    <section class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Categorías</h1>
            <span class="text-sm text-gray-500">Explora las noticias por categoría</span>
        </div>

        <!-- Lista de categorías -->
        <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="categories">
            <button
                class="category-btn h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-700 hover:bg-gray-100 font-medium"
                data-id="1">
                Nacionales
            </button>
            <button
                class="category-btn h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-700 hover:bg-gray-100 font-medium"
                data-id="2">
                Deportes
            </button>
            <button
                class="category-btn h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-700 hover:bg-gray-100 font-medium"
                data-id="3">
                Economía
            </button>
            <button
                class="category-btn h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-700 hover:bg-gray-100 font-medium"
                data-id="4">
                Internacional
            </button>
            <button
                class="category-btn h-24 rounded-xl bg-gray-50 border grid place-items-center text-gray-700 hover:bg-gray-100 font-medium"
                data-id="5">
                Tecnología
            </button>
        </div>
    </section>

    <!-- Contenedor donde se mostraran las noticias -->
    <section class="mt-8" id="news-container"></section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.category-btn');
            const container = document.getElementById('news-container');

            buttons.forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;

                    // Estilo de seleccion
                    buttons.forEach(b => b.classList.remove('ring-2', 'ring-gray-900/10'));
                    btn.classList.add('ring-2', 'ring-gray-900/10');

                    container.innerHTML = `
                <div class="text-center py-8 text-gray-500 animate-pulse">
                    Cargando noticias…
                </div>
            `;

                    try {
                        const res = await fetch(`/api/categories/${id}/news`);
                        const news = await res.json();

                        if (!news.length) {
                            container.innerHTML = `
                        <div class="text-center py-8 text-gray-400">
                            No hay noticias disponibles para esta categoría.
                        </div>
                    `;
                            return;
                        }

                        container.innerHTML = `
                    <h2 class="text-lg font-semibold mb-4">Noticias de ${btn.textContent.trim()}</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        ${news.map(n => `
                                    <a href="/noticias/${n.id}"
                                       class="group bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 hover:shadow-md transition">
                                        <img src="${n.image_url ?? 'https://via.placeholder.com/300x200'}"
                                             alt="${n.title}"
                                             class="h-36 w-full object-cover">
                                        <div class="p-4">
                                            <h3 class="text-base font-semibold leading-tight line-clamp-2 group-hover:underline">${n.title}</h3>
                                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">${n.excerpt ?? ''}</p>
                                            <div class="mt-3 text-xs text-gray-500">${new Date(n.published_at).toLocaleDateString()}</div>
                                        </div>
                                    </a>
                                `).join('')}
                    </div>
                `;
                    } catch (e) {
                        console.error(e);
                        container.innerHTML =
                            `<p class="text-center text-red-500 py-8">Error al cargar las noticias.</p>`;
                    }
                });
            });
        });
    </script>
@endsection
