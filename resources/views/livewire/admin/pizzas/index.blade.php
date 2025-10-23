<div class="space-y-6">

    {{-- Encabezado + botón  “Nueva Pizza” --}}
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-3xl font-semibold text-gray-500 dark:text-gray-100">
            {{ __('Catálogo de Pizzas') }}
        </h1>

        <flux:button variant="filled" icon="plus" wire:click="openCreate">
            {{ __('Nueva pizza') }}
        </flux:button>
    </div>

    {{-- Modal (crear/editar)  --}}
    <flux:modal wire:model="showModal" variant="flyout" class="max-w-2xl">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $editingId ? __('Editar pizza') : __('Crear nueva pizza') }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $editingId
                        ? __('Actualiza los datos de la pizza y sus ingredientes.')
                        : __('Completa los datos de la pizza y selecciona sus ingredientes.') }}
                </flux:text>
            </div>

            {{--  Hijo form que crea/edita --}}
            @livewire('admin.pizzas.form',
                ['pizzaId' => $editingId],
                key('pizza-form-'.($editingId ?? 'new'))
            )
        </div>
    </flux:modal>

    {{-- Tabla y acciones --}}
    <div class="bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
        <div class="p-6 overflow-x-auto">

            {{-- Tabla de Pizzas --}}
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Nombre') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Precio') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Ingredientes') }}
                        </th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                    @forelse ($pizzas as $pizza)
                        <tr wire:key="row-{{ $pizza->id }}">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                {{ $pizza->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-zinc-300">
                                € {{ number_format($pizza->price, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-zinc-400">
                                {{ $pizza->ingredientes_count }} {{ Str::plural('ingrediente', $pizza->ingredientes_count) }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex gap-2">
                                    <flux:button
                                        size="sm"
                                        icon="pencil-square"
                                        wire:click="openEdit({{ $pizza->id }})"
                                    >
                                        {{ __('Editar') }}
                                    </flux:button>

                                    <flux:button
                                        variant="danger"
                                        size="sm"
                                        icon="trash"
                                        x-data
                                        @click="if (confirm('¿Eliminar esta pizza?')) { $wire.delete({{ $pizza->id }}) }"
                                    >
                                        {{ __('Eliminar') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-zinc-500 dark:text-zinc-400" colspan="4">
                                {{ __('No hay pizzas registradas. ¡Crea una para empezar!') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $pizzas->links() }}
            </div>
        </div>
    </div>
</div>
