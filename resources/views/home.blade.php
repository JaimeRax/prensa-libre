@extends('layouts.app')
@section('title', 'Inicio')

@section('content')
    <!-- Hero -->
    <section class="mb-10" id="hero">
        <div class="grid lg:grid-cols-12 gap-6">
            <article
                class="lg:col-span-8 bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 min-h-[320px] relative"
                id="hero-card">

                <!-- Skeleton -->
                <div class="animate-pulse h-full">
                    <div class="h-56 bg-gray-200"></div>
                    <div class="p-6 space-y-3">
                        <div class="h-6 bg-gray-200 w-3/4 rounded"></div>
                        <div class="h-4 bg-gray-200 w-full rounded"></div>
                        <div class="h-4 bg-gray-200 w-5/6 rounded"></div>
                    </div>
                </div>
            </article>

            <div class="lg:col-span-4 grid sm:grid-cols-2 lg:grid-cols-1 gap-6" id="hero-side">
                @for ($i = 0; $i < 2; $i++)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100">
                        <div class="animate-pulse">
                            <div class="h-32 bg-gray-200"></div>
                            <div class="p-4 space-y-2">
                                <div class="h-5 bg-gray-200 w-3/4 rounded"></div>
                                <div class="h-4 bg-gray-200 w-5/6 rounded"></div>
                            </div>
                        </div>
                    </article>
                @endfor
            </div>
        </div>
    </section>

    <!-- Grid -->
    <section>
        <h2 class="text-lg font-semibold mb-4">Últimas noticias</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="news-grid">
            @for ($i = 0; $i < 8; $i++)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100">
                    <div class="animate-pulse">
                        <div class="h-36 bg-gray-200"></div>
                        <div class="p-4 space-y-2">
                            <div class="h-5 bg-gray-200 w-4/5 rounded"></div>
                            <div class="h-4 bg-gray-200 w-5/6 rounded"></div>
                        </div>
                    </div>
                </article>
            @endfor
        </div>
    </section>

    <script>
        // Utilidad: crea card HTML
        function card(n, big = false) {
            const img = n.image_url ? `<img src="${n.image_url}" alt="${n.title}" loading="lazy"
                           class="${big ? 'h-64' : 'h-36'} w-full object-cover">` : '';
            const text = `
        <div class="${big ? 'p-6' : 'p-4'}">
          <h3 class="${big ? 'text-xl' : 'text-base'} font-semibold leading-tight line-clamp-${big ? '2' : '2'}">${n.title}</h3>
          ${n.excerpt ? `<p class="mt-2 text-sm text-gray-600 line-clamp-${big ? '3' : '2'}">${n.excerpt}</p>` : ''}
          <div class="mt-3 text-xs text-gray-500">${new Date(n.published_at).toLocaleDateString()}</div>
        </div>`;

            return `<article class="group bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 hover:shadow-md transition">
        <div class="relative">
          ${img}
          <div class="absolute inset-0 ring-0 group-hover:ring-2 group-hover:ring-gray-900/10 transition"></div>
        </div>
        ${text}
      </article>`;
        }

        // Carga desde API y pinta hero + grid
        fetch('/api/news')
            .then(r => r.json())
            .then(items => {
                if (!Array.isArray(items) || items.length === 0) return;

                // Hero: primera noticia grande + dos laterales
                const [first, second, third, ...rest] = items;

                document.getElementById('hero-card').outerHTML = card(first, true);

                const side = document.getElementById('hero-side');
                side.innerHTML = [second, third].filter(Boolean).map(n => card(n, false)).join('');

                // Grid: resto
                const grid = document.getElementById('news-grid');
                grid.innerHTML = (rest.length ? rest : items).slice(0, 12).map(n => card(n)).join('');
            })
            .catch(console.error);
    </script>
@endsection
