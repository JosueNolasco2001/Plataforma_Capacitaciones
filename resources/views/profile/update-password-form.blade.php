<x-form-section submit="updatePassword">
    <x-slot name="title">
        <span class="text-white font-semibold">{{ __('Actualizar Contraseña') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-gray-300">{{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerse segura.') }}</span>
    </x-slot>

    <x-slot name="form" class="">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Contraseña Actual') }}" class="!text-white font-medium" />
            <x-input id="current_password" type="password" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400" wire:model="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2 text-red-400" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('Nueva Contraseña') }}" class="!text-white font-medium" />
            <x-input id="password" type="password" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400" wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2 text-red-400" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" class="!text-white font-medium" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400" wire:model="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2 text-red-400" />
        </div>
    </x-slot>

    <x-slot name="actions" class="">
        <x-action-message class="me-3 text-green-400" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button class="bg-blue-600 hover:bg-blue-700 text-white font-medium">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>