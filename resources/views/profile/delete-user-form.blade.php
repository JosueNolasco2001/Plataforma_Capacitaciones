<x-action-section>
    <x-slot name="title">
        <span class="text-white font-semibold">{{ __('Eliminar Cuenta') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-white">{{ __('Elimina permanentemente tu cuenta.') }}</span>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-black">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled"
                class="bg-red-600 hover:bg-red-700 text-white font-medium">
                {{ __('Eliminar Cuenta') }}
            </x-danger-button>
        </div>

        <!-- Modal de Confirmación para Eliminar Usuario -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                <span class="text-white font-semibold">{{ __('Eliminar Cuenta') }}</span>
            </x-slot>

            <x-slot name="content">
                <span class="text-white">{{ __('¿Estás seguro de que quieres eliminar tu cuenta? Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.') }}</span>

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" 
                        class="mt-1 block w-3/4 bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400"
                        autocomplete="current-password"
                        placeholder="{{ __('Contraseña') }}"
                        x-ref="password"
                        wire:model="password"
                        wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2 text-red-400" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled"
                    class="!bg-gray-700 text-white hover:bg-gray-600 border-gray-600">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 bg-red-600 hover:bg-red-700 text-white font-medium" 
                    wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>