@extends('layouts.app')
@section('title', 'Iniciar sesión')

@section('content')
    <div class="min-h-[70vh] grid place-items-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden">
                <div class="px-6 pt-6 pb-4">
                    <h1 class="text-2xl font-semibold">Bienvenido de nuevo</h1>
                    <p class="text-sm text-gray-600 mt-1">Accede con tu cuenta para continuar.</p>

                    @if (session('status'))
                        <div class="mt-4 rounded-lg bg-green-50 text-green-800 text-sm px-3 py-2">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Errores globales --}}
                    @if ($errors->any())
                        <div class="mt-4 rounded-lg bg-red-50 text-red-800 text-sm px-3 py-2">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" class="mt-6 space-y-4" method="POST">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">Correo electrónico</label>
                            <input autofocus
                                class="mt-1 w-full rounded-xl border border-gray-300 focus:border-gray-600 focus:ring-gray-900/20 px-3 py-2"
                                id="email" name="email" required type="email" value="{{ old('email') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password">Contraseña</label>
                            <div class="mt-1 relative">
                                <input
                                    class="w-full rounded-xl border border-gray-300 focus:border-gray-900 focus:ring-gray-900/20 px-3 py-2 pr-10"
                                    id="password" name="password" required type="password">
                                <button aria-label="Mostrar u ocultar contraseña"
                                    class="absolute inset-y-0 right-0 px-3 text-black hover:text-gray-800"
                                    id="toggle-password" type="button">
                                    <i class="icon-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input class="rounded border-gray-300 text-gray-900 focus:ring-gray-900/20" name="remember"
                                    type="checkbox">
                                Recuérdame
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-700 hover:underline" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <button
                            class="w-full rounded-xl bg-gray-900 text-white py-2.5 font-medium hover:bg-gray-800 transition"
                            type="submit">
                            Iniciar sesión
                        </button>
                    </form>

                    <div class="mt-4">
                        <div class="flex items-center gap-3">
                            <div class="h-px flex-1 bg-gray-200"></div>
                            <span class="text-xs text-gray-500">o continúa con</span>
                            <div class="h-px flex-1 bg-gray-200"></div>
                        </div>

                        <a class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white py-2.5 text-sm font-medium hover:bg-gray-50 transition"
                            href="{{ route('google.redirect') }}">
                            <img alt="" class="h-5 w-5" src="https://www.svgrepo.com/show/475656/google-color.svg">
                            Google
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 text-sm text-gray-700">
                    ¿No tienes cuenta?
                    <a class="font-medium hover:underline" href="{{ route('register') }}">Crear cuenta</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const btn = document.getElementById('toggle-password');
        const input = document.getElementById('password');
        if (btn && input) {
            btn.addEventListener('click', () => {
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        }
    </script>
@endsection
