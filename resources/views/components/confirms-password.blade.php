@props(['title' => __('Confirmar Contraseña'), 'content' => __('Por tu seguridad, confirma tu contraseña para continuar.'), 'button' => __('Confirmar')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-dialog-modal wire:model.live="confirmingPassword">
    <x-slot name="title">
        <span class="text-white font-semibold">{{ $title }}</span>
    </x-slot>

    <x-slot name="content">
        <span class="text-gray-300">{{ $content }}</span>

        <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <x-input type="password" 
                class="mt-1 block w-3/4 bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400" 
                placeholder="{{ __('Contraseña') }}" 
                autocomplete="current-password"
                x-ref="confirmable_password"
                wire:model="confirmablePassword"
                wire:keydown.enter="confirmPassword" />

            <x-input-error for="confirmable_password" class="mt-2 text-red-400" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="stopConfirmingPassword" wire:loading.attr="disabled" 
            class="bg-gray-700 !text-black hover:bg-gray-600 border-gray-600">
            {{ __('Cancelar') }}
        </x-secondary-button>

        <x-button class="ms-3 bg-blue-600 hover:bg-blue-700 text-white font-medium" 
            dusk="confirm-password-button" 
            wire:click="confirmPassword" 
            wire:loading.attr="disabled">
            {{ $button }}
        </x-button>
    </x-slot>
</x-dialog-modal>
@endonce