<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
    </div>

    <form action="{{ route('password.confirm') }}" method="POST">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label :value="__('Password')" for="password" />

            <x-text-input autocomplete="current-password" class="block mt-1 w-full" id="password" name="password" required
                type="password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
