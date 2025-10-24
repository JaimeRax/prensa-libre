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

            let currentCategory = null;
            let page = 1,
                lastPage = Infinity,
                loading = false;
            const perPage = 3;

            function renderSkeleton() {
                return `<div class="text-center py-8 text-gray-500 animate-pulse">Cargando noticias…</div>`;
            }

            function renderFrame(name) {
                return `
      <h2 class="text-lg font-semibold mb-4">Noticias de ${name}</h2>
      <div id="grid" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>
      <div class="mt-6 text-center">
        <button id="load-more" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 disabled:opacity-50">
          Cargar más
        </button>
      </div>
    `;
            }

            function card(n) {
                const href = window.IS_AUTH ? `${window.NEWS_URL_PREFIX}/${n.id}` : window.LOGIN_URL;
                return `
    <a href="${href}"
       class="group bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 hover:shadow-md transition"
       ${window.IS_AUTH ? '' : 'title="Inicia sesión para ver el detalle"'}>
      <img src="${n.image_url ?? 'https://via.placeholder.com/300x200'}"
           alt="${n.title}" class="h-36 w-full object-cover">
      <div class="p-4">
        <h3 class="text-base font-semibold leading-tight line-clamp-2 group-hover:underline">${n.title}</h3>
        ${n.excerpt ? `<p class="mt-1 text-sm text-gray-600 line-clamp-2">${n.excerpt}</p>` : ''}
        <div class="mt-3 text-xs text-gray-500 flex items-center justify-between">
          <span>${new Date(n.published_at).toLocaleDateString()}</span>
          ${n.autor ? `<span class="italic text-gray-700">Por ${n.autor}</span>` : ''}
        </div>
      </div>
    </a>
  `;
            }

            async function loadPage(catId) {
                if (loading || page > lastPage) return;
                loading = true;

                const btn = document.getElementById('load-more');
                if (btn) {
                    btn.disabled = true;
                    btn.textContent = 'Cargando…';
                }

                try {
                    const res = await apiFetch(
                        `/api/categories/${catId}/news?page=${page}&per_page=${perPage}`);
                    const {
                        data,
                        meta
                    } = await res.json();

                    const grid = document.getElementById('grid');

                    if (page === 1 && data.length === 0) {
                        grid.innerHTML =
                            `<div class="col-span-full text-center text-gray-400 py-8">No hay noticias en esta categoría.</div>`;
                        if (btn) btn.style.display = 'none';
                        lastPage = 0;
                        return;
                    }

                    grid.insertAdjacentHTML('beforeend', data.map(card).join(''));

                    lastPage = meta.last_page;
                    page++;

                    if (btn) {
                        if (page > lastPage) btn.style.display = 'none';
                        btn.disabled = false;
                        btn.textContent = 'Cargar más';
                    }
                } catch (e) {
                    console.error(e);
                    if (btn) btn.textContent = 'Reintentar';
                } finally {
                    loading = false;
                }
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = Number(btn.dataset.id);
                    const name = btn.textContent.trim();

                    // Estilo seleccionado
                    buttons.forEach(b => b.classList.remove('ring-2', 'ring-gray-900/10'));
                    btn.classList.add('ring-2', 'ring-gray-900/10');

                    // Reset de paginación
                    currentCategory = id;
                    page = 1;
                    lastPage = Infinity;

                    // Render base + botón al final
                    container.innerHTML = renderFrame(name);

                    // Cargar primera página
                    loadPage(id);

                    // Wire del botón inferior
                    const more = document.getElementById('load-more');
                    more.onclick = () => loadPage(id);
                });
            });
        });
    </script>

@endsection
