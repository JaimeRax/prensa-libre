@extends('layouts.app')
@section('title', 'Crear cuenta')

@section('content')
    <div class="min-h-[70vh] grid place-items-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden">
                <div class="px-6 pt-6 pb-4">
                    <h1 class="text-2xl font-semibold">Crear cuenta</h1>
                    <p class="text-sm text-gray-600 mt-1">Únete para guardar favoritos y más.</p>

                    @if ($errors->any())
                        <div class="mt-4 rounded-lg bg-red-50 text-red-800 text-sm px-3 py-2">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" class="mt-6 space-y-4" method="POST">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Nombre</label>
                            <input
                                class="mt-1 w-full rounded-xl border border-gray-300 focus:border-gray-900 focus:ring-gray-900/20 px-3 py-2"
                                id="name" name="name" required type="text" value="{{ old('name') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">Correo electrónico</label>
                            <input
                                class="mt-1 w-full rounded-xl border border-gray-300 focus:border-gray-900 focus:ring-gray-900/20 px-3 py-2"
                                id="email" name="email" required type="email" value="{{ old('email') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password">Contraseña</label>
                            <input
                                class="mt-1 w-full rounded-xl border border-gray-300 focus:border-gray-900 focus:ring-gray-900/20 px-3 py-2"
                                id="password" name="password" required type="password">
                            <p class="mt-1 text-xs text-gray-500">
                                Mínimo 8 caracteres. Usa mayúsculas, minúsculas y números.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password_confirmation">Confirmar
                                contraseña</label>
                            <input
                                class="mt-1 w-full rounded-xl border border-gray-300 focus:border-gray-900 focus:ring-gray-900/20 px-3 py-2"
                                id="password_confirmation" name="password_confirmation" required type="password">
                        </div>

                        <button
                            class="w-full rounded-xl bg-gray-900 text-white py-2.5 font-medium hover:bg-gray-800 transition"
                            type="submit">
                            Crear cuenta
                        </button>
                    </form>

                    <div class="mt-4">
                        <div class="flex items-center gap-3">
                            <div class="h-px flex-1 bg-gray-200"></div>
                            <span class="text-xs text-gray-500">o regístrate con</span>
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
                    ¿Ya tienes cuenta?
                    <a class="font-medium hover:underline" href="{{ route('login') }}">Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
@endsection
