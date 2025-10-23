<?php

namespace App\Livewire\Admin\Pizzas;

use Livewire\Component;

use App\Models\Pizza;
use App\Models\Ingrediente;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public ?int $pizzaId = null;
    public ?Pizza $pizza = null;

    public string $name = '';
    public ?string $description = null;
    public string|float|int $price = '';
    /** @var array<int> */
    public array $ingredientesSeleccionados = [];

    public function mount(?int $pizzaId = null): void
    {
        $this->pizzaId = $pizzaId;

        if ($this->pizzaId) {
            $this->pizza = Pizza::findOrFail($this->pizzaId);
            $this->name = $this->pizza->name;
            $this->description = $this->pizza->description;
            $this->price = $this->pizza->price;
            $this->ingredientesSeleccionados = $this->pizza
                ->ingredientes()->pluck('ingredientes.id')->all();
        }
    }

    public function rules(): array
    {
        return [
            'name'  => ['required','string','min:3','max:100', Rule::unique('pizzas','name')->ignore($this->pizzaId)],
            'description' => ['nullable','string','max:500'],
            'price' => ['required','numeric','min:0'],
            'ingredientesSeleccionados' => ['array'],
            'ingredientesSeleccionados.*' => ['integer','exists:ingredientes,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la pizza es obligatorio.',
            'name.min'      => 'El nombre debe tener al menos :min caracteres.',
            'name.max'      => 'El nombre no puede superar :max caracteres.',
            'name.unique'   => 'Ya existe una pizza con ese nombre.',

            'description.max' => 'La descripción no puede superar :max caracteres.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric'  => 'El precio debe ser numérico.',
            'price.min'      => 'El precio no puede ser negativo.',

            'ingredientesSeleccionados.*.exists' => 'Algún ingrediente seleccionado no existe.',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ];

        if ($this->pizzaId) {
            $this->pizza->update($data);
            $this->dispatch('toast', message: 'Pizza editada correctamente.', type: 'success');
        } else {
            $this->pizza = Pizza::create($data);
            $this->pizzaId = $this->pizza->id;
            $this->dispatch('toast', message: 'Pizza guardada correctamente.', type: 'success');
        }

        $this->pizza->ingredientes()->sync($this->ingredientesSeleccionados);

        // Avisar al padre (Index) para cerrar el modal y refrescar
        $this->dispatch('pizza-refreshed');

    }

    public function render()
    {
        return view('livewire.admin.pizzas.form', [
            'ingredientes' => Ingrediente::orderBy('name')->get(['id','name']),
            'editMode' => (bool) $this->pizzaId,
        ]);
    }
}
