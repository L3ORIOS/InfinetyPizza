<?php

namespace App\Livewire\Admin\Pedidos;

use Livewire\Component;

use App\Models\Pedido;
use Livewire\WithPagination;

class Index extends Component
{
use WithPagination;

    public function render()
    {
        // Eager loading para evitar N+1 y ordenar por los más recientes
        $pedidos = Pedido::query()
            ->with([
                'user:id,name,email',
                'pizza:id,name',
            ])
            ->orderByDesc('fecha_hora_pedido')

            ->paginate(5);

        return view('livewire.admin.pedidos.index', compact('pedidos'));
    }
}
