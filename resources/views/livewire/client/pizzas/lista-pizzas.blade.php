<div class="mx-auto max-w-7xl px-4 py-10">

    <h1 class="mb-6 text-3xl font-bold text-on-surface dark:text-on-surface-dark">
        {{ __('Pizzas disponibles') }}
    </h1>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($pizzas as $pizza)
            <flux:callout icon="fire" variant="secondary" inline class="h-full">
                <flux:callout.heading class="flex items-center justify-between gap-2">
                    <span>{{ $pizza->name }}</span>
                    <span class="text-base font-semibold">€ {{ number_format($pizza->price, 2) }}</span>
                </flux:callout.heading>

                <flux:callout.text>

                    {{-- Imagen --}}
                    <div class="mb-3">
                        <img
                            src="{{ $pizza->image ?? '/order.png' }}"
                            alt="Pizza {{ $pizza->name }}"
                            class="w-full max-h-40 object-cover rounded-lg"
                        >
                    </div>

                    @if($pizza->description)
                        <p class="text-sm mb-2">{{ $pizza->description }}</p>
                    @endif

                    <p class="text-xs opacity-80">
                        <span class="font-semibold">{{ __('Ingredientes') }}:</span>
                        @if($pizza->ingredientes->isEmpty())
                            —
                        @else
                            {{ $pizza->ingredientes->pluck('name')->implode(', ') }}
                        @endif
                    </p>
                </flux:callout.text>

                <x-slot name="actions">
                    <flux:button
                        size="sm"
                        icon="shopping-cart"
                        wire:click="order({{ $pizza->id }})"
                    >
                        {{ __('Hacer pedido') }}
                    </flux:button>
                </x-slot>
            </flux:callout>
        @endforeach
    </div>
</div>
