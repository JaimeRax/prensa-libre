<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" class="mb-4" />

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label :value="__('Email')" for="email" />
            <x-text-input :value="old('email')" autofocus class="block border mt-1 w-full" id="email" name="email"
                required type="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
