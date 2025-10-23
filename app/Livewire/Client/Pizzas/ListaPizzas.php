<?php

namespace App\Livewire\Client\Pizzas;

use Livewire\Component;

use App\Models\Pedido;
use App\Models\Pizza;
use Illuminate\Support\Facades\Auth;

use App\Events\OrderCreated;


class ListaPizzas extends Component
{
    public $pizzas;

    public function mount(): void
    {
        // Cargar pizzas con sus ingredientes para evitar N+1
        $this->pizzas = Pizza::query()
            ->with(['ingredientes:id,name'])
            ->latest() // más recientes primero
            ->get(['id','name','description','price']);
    }

    public function order(int $pizzaId)
    {
        if (!Auth::check()) {
            // Si no está logueado, enviar a login
            return redirect()->route('login');
        }

        $pizza = Pizza::findOrFail($pizzaId);
        // Crear pedido rápido (fecha/hora = ahora)
        $pedido = Pedido::create([
            'user_id'            => Auth::id(),
            'pizza_id'           => $pizzaId,
            'fecha_hora_pedido'  => now(),
        ]);

            // Disparar el evento → Listener encola el Job → Job envía el mail
            OrderCreated::dispatch($pedido);

        //$this->dispatch('pedido-ok', message: "¡Pedido de {$pizza->name} creado!");
        $this->dispatch('toast', message: "¡Pedido de {$pizza->name} creado!", type: 'success');
    }
    public function render()
    {
        return view('livewire.client.pizzas.lista-pizzas');
    }
}
