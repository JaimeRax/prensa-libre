@extends('layouts.app')
@section('title', 'Inicio')

@section('content')
    <script>
        window.isAuth = @json(auth()->check());
    </script>

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
        document.addEventListener("DOMContentLoaded", () => {
            const grid = document.getElementById("news-grid");
            const heroCard = document.getElementById("hero-card");
            const heroSide = document.getElementById("hero-side");

            // Crear botón "Cargar más"
            const loadMoreBtn = document.createElement("button");
            loadMoreBtn.textContent = "Cargar más";
            loadMoreBtn.className =
                "mt-6 mx-auto block px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 disabled:opacity-50";
            grid.insertAdjacentElement("afterend", loadMoreBtn);

            let page = 1;
            const perPage = 3;
            let lastPage = Infinity;
            let loading = false;

            function card(n, big = false) {
                const href = window.IS_AUTH ? `${window.NEWS_URL_PREFIX}/${n.id}` : window.LOGIN_URL;

                const img = n.image_url ?
                    `<img src="${n.image_url}" alt="${n.title}" loading="lazy"
           class="${big ? "h-64" : "h-36"} w-full object-cover rounded-t-2xl">` :
                    "";
                const text = `
      <div class="${big ? "p-6" : "p-4"}">
        <h3 class="${big ? "text-xl" : "text-base"} font-semibold leading-tight line-clamp-2">${n.title}</h3>
        ${n.excerpt ? `<p class="mt-2 text-sm text-gray-600 line-clamp-2">${n.excerpt}</p>` : ""}
        <div class="mt-3 text-xs text-gray-500">${new Date(n.published_at).toLocaleDateString()}</div>
      </div>`;

                return `
      <a href="${href}" class="group bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 hover:shadow-md transition"
         ${window.IS_AUTH ? '' : 'title="Inicia sesión para ver el detalle"'}>
        ${img}
        ${text}
      </a>`;
            }

            async function loadNews() {
                if (loading || page > lastPage) return;
                loading = true;
                loadMoreBtn.disabled = true;
                loadMoreBtn.textContent = "Cargando...";

                try {
                    const res = await apiFetch(`/api/news?page=${page}&per_page=${perPage}`);
                    const {
                        data,
                        meta
                    } = await res.json();

                    if (page === 1 && data.length) {
                        const [first, second, third, ...rest] = data;
                        heroCard.outerHTML = card(first, true);
                        heroSide.innerHTML = [second, third].filter(Boolean).map(n => card(n)).join("");
                        grid.innerHTML = rest.map(n => card(n)).join("");
                    } else if (page > 1 && data.length) {
                        grid.insertAdjacentHTML("beforeend", data.map(n => card(n)).join(""));
                    }

                    lastPage = meta.last_page;
                    page++;

                    if (page > lastPage) loadMoreBtn.style.display = "none";
                } catch (err) {
                    console.error("Error cargando noticias:", err);
                } finally {
                    loading = false;
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = "Cargar más";
                }
            }

            loadNews();
            loadMoreBtn.addEventListener("click", loadNews);
        });
    </script>

@endsection
