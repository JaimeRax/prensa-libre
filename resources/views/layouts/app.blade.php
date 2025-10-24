<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>@yield('title', 'PrensaLibre')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        window.IS_AUTH = @json(auth()->check());
        window.LOGIN_URL = @json(route('login'));
        window.NEWS_URL_PREFIX = @json(url('/noticias'));
    </script>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Topbar / Navbar -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b">
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand -->
                <a class="flex items-center gap-2 group" href="{{ url('/') }}">
                    <div
                        class="h-9 w-9 rounded-xl bg-gray-900 text-white grid place-items-center font-bold group-hover:scale-105 transition">
                        PL
                    </div>
                    <span class="text-lg font-semibold tracking-tight">PrensaLibre </span>
                </a>

                <!-- Desktop nav -->
                <div class="hidden md:flex items-center gap-6">
                    <a class="px-2 py-1 rounded-md text-sm font-medium {{ request()->is('/') ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900' }}"
                        href="{{ url('/') }}">
                        Inicio
                    </a>

                    @auth
                        <a class="px-2 py-1 rounded-md text-sm font-medium {{ request()->is('categorias') ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900' }}"
                            href="{{ url('/categorias') }}">
                            Categorías
                        </a>

                        <a class="text-sm font-medium hover:underline" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    @endauth

                    <!-- Search -->
                    <div class="relative">
                        <input
                            class="w-56 rounded-xl border border-gray-300 bg-white/70 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-gray-900/10 transition"
                            id="global-search" placeholder="Buscar…" type="search">
                        <svg class="absolute right-2 top-2.5 h-5 w-5 text-gray-400 pointer-events-none" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                        </svg>
                    </div>
                </div>

                <!-- Auth -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <img alt="" class="h-8 w-8 rounded-full ring-2 ring-gray-200"
                            src="{{ auth()->user()->avatar }}">
                        <span class="text-sm">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="text-sm underline underline-offset-4 hover:no-underline">Salir</button>
                        </form>
                    @else
                        <a class="text-sm font-medium hover:underline" href="{{ route('login') }}">Iniciar sesión</a>
                        <a class="text-sm text-white bg-gray-900 hover:bg-gray-800 rounded-xl px-3 py-1.5 transition"
                            href="{{ route('register') }}">Crear cuenta</a>
                    @endauth
                </div>

                <!-- Mobile burger -->
                <button aria-label="Abrir menú"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-lg hover:bg-gray-100"
                    id="nav-burger">
                    <svg class="h-6 w-6 text-gray-700" fill="none" id="burger-icon" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" stroke-width="1.5" />
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div class="md:hidden hidden pb-4 border-t" id="mobile-menu">
                <div class="pt-3 flex flex-col gap-2">
                    <a class="px-2 py-2 rounded-md text-sm {{ request()->is('/') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}"
                        href="{{ url('/') }}">Inicio</a>
                    <a class="px-2 py-2 rounded-md text-sm {{ request()->is('categorias') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}"
                        href="{{ url('/categorias') }}">Categorías</a>
                    <div class="px-2 py-2">
                        <input
                            class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-gray-900/10"
                            placeholder="Buscar…" type="search">
                    </div>

                    @auth
                        <div class="flex items-center gap-3 px-2 py-2">
                            <img alt="" class="h-8 w-8 rounded-full ring-2 ring-gray-200"
                                src="{{ auth()->user()->avatar ?? 'https://i.pravatar.cc/100?img=5' }}">
                            <span class="text-sm">{{ auth()->user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" class="px-2 py-2" method="POST">
                            @csrf
                            <button class="w-full text-left text-sm underline">Salir</button>
                        </form>
                    @else
                        <div class="px-2 py-2 flex gap-3">
                            <a class="text-sm font-medium hover:underline" href="{{ route('login') }}">Iniciar sesión</a>
                            <a class="text-sm text-white bg-gray-900 hover:bg-gray-800 rounded-xl px-3 py-1.5 transition"
                                href="{{ route('register') }}">Crear cuenta</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Main -->
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 text-sm text-gray-500">
            © {{ date('Y') }} PrensaLibre demo
        </div>
    </footer>
</body>
</html>
