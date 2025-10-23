<?php

namespace App\Livewire\Admin\Pizzas;

use Livewire\Component;

use App\Models\Pizza;
use App\Models\Pedidos;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    // Control del modal + id en edición
    public bool $showModal = false;
    public ?int $editingId = null;

    // Abrir modal para crear nueva pizza
    public function openCreate(): void
    {
        $this->editingId = null;
        $this->showModal = true;
    }

    // Abrir modal para editar pizza existente
    public function openEdit(int $id): void
    {
        $this->editingId = $id;
        $this->showModal = true;
    }

    // Evento de refresco desde el componente Form
    #[On('pizza-refreshed')]
    public function pizzaRefreshed(): void
    {
        // Cierra modal y refresca lista
        $this->reset('showModal', 'editingId');
        $this->resetPage();
    }

    public function delete(int $id): void
    {
       $pizza = Pizza::withCount('pedidos')->findOrFail($id);

        if ($pizza->pedidos_count > 0) {
            $this->dispatch('toast', message: 'No puedes eliminar una pizza con pedidos asociados.', type: 'error');
            return;
        }

        // Quita relaciones de la tabla pivot para no romper FKs
        $pizza->ingredientes()->detach();

        $pizza->delete();

        $this->dispatch('toast', message: 'Pizza eliminada correctamente.', type: 'success');
        }

    public function render()
    {
        $pizzas = Pizza::query()
            ->withCount('ingredientes')
            ->latest()
            ->orderBy('name')
            ->paginate(5);

        return view('livewire.admin.pizzas.index', compact('pizzas'));
    }
}
