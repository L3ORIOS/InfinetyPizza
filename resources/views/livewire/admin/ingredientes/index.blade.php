<?php

use Livewire\Volt\Component;
use App\Models\Ingrediente;
use Livewire\WithPagination;
use Livewire\Attributes\On;


new class extends Component {
    //
    use WithPagination;

    // Control del modal + id en edición
    public bool $showModal = false; // Visible/invisible del modal
    public ?int $editingId = null; // Null = crear; ID = editar

    // Data binding (lista paginada, ordenada por más recientes)
    public function with(): array
    {
        return [
            'ingredientes' => Ingrediente::latest()->paginate(5),
        ];
    }

    // Abrir modal para crear
    public function openCreate(): void
    {
        $this->editingId = null;
        $this->showModal = true;
    }

    // Abrir modal para editar
    public function openEdit(int $id): void
    {
        $this->editingId = $id;
        $this->showModal = true;
    }

    // El hijo avisa que se creó/actualizó y refrescamos lista + cerramos modal
    #[On('ingrediente-refreshed')]
    public function ingredienteRefreshed(): void
    {
        $this->resetPage();
        //$this->reset('showModal', 'editingId');
    }

    public function delete(int $id): void
    {
        Ingrediente::findOrFail($id)->delete();
        $this->dispatch('toast', message: 'Ingrediente eliminado correctamente.', type: 'error');
    }
}; ?>

<!-- CONTENIDO PRINCIPAL -->
<div>
    <div>
        {{-- Encabezado y Botón de Crear --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-semibold text-gray-500 dark:text-gray-100">
                {{ __('Catálogo de Ingredientes') }}
            </h1>
            <flux:button variant="filled" icon="plus" wire:click="openCreate">
                {{ __('Nuevo Ingrediente') }}
            </flux:button>
        </div>

        {{-- Modal único reutilizable (crear o editar según $editingId) --}}
        <flux:modal wire:model="showModal" variant="flyout" class="max-w-md">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">
                        {{ $editingId ? __('Editar Ingrediente') : __('Crear Nuevo Ingrediente') }}
                    </flux:heading>
                    <flux:text class="mt-2">
                        {{ $editingId ? __('Actualiza el nombre del ingrediente.') : __('Introduce el nuevo ingrediente.') }}
                    </flux:text>
                </div>

                {{-- El MISMO componente sirve para ambos casos --}}
                @livewire('admin.ingredientes.form', ['ingredienteId' => $editingId], key('ingrediente-form-'.($editingId ?? 'new')))
            </div>
        </flux:modal>

        {{-- Contenedor de la Tabla --}}
        <div class="bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
            <div class="p-6">
                {{-- TABLA DE DATOS --}}
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-zinc-400">
                            {{ __('ID') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Nombre') }}
                        </th>
                        <th class="relative px-6 py-3">
                            <span class="sr-only">{{ __('Acciones') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                    @forelse ($ingredientes as $ingrediente)
                        <tr wire:key="row-{{ $ingrediente->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $ingrediente->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-zinc-400">
                                {{ $ingrediente->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="inline-flex gap-2">
                                    {{-- Antes navegabas a la ruta; ahora abrimos el modal en modo edición --}}
                                    <flux:button
                                        size="sm"
                                        icon="pencil-square"
                                        wire:click="openEdit({{ $ingrediente->id }})"
                                    >
                                        {{ __('Editar') }}
                                    </flux:button>

                                    <flux:button
                                        variant="danger"
                                        size="sm"
                                        icon="trash"
                                        x-data
                                        x-on:click.prevent="if (confirm('¿Estás seguro de que deseas eliminar este ingrediente?')) { $wire.delete({{ $ingrediente->id }}) }"
                                    >
                                        {{ __('Eliminar') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center py-4">
                            <td class="text-zinc-500 dark:text-zinc-400" colspan="3">
                                {{ __('No hay ingredientes registrados. ¡Crea uno para empezar!') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

                {{-- Paginación --}}
                <div class="mt-4">
                    {{ $ingredientes->links() }}
                </div>

            </div>
        </div>
    </div>
</div>



