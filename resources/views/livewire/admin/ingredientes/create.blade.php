<?php

use Livewire\Volt\Component;
use App\Models\Ingrediente;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;



new class extends Component {

    // Propiedades del formulario
    #[Validate(as: 'Ingrediente')]
    public string $name = '';

    // Reglas de validación
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('ingredientes', 'name'),
            ],
        ];
    }

    // Método para guardar el nuevo ingrediente
    public function store(): void
    {
        // 1. Validar las propiedades
        $validated = $this->validate(
            $this->rules(), // Argumento 1: Pasamos las reglas explícitamente
            [
                'name.unique' => 'El :attribute ya ha sido registrado.',
            ]
        );

        // 2. Crear el ingrediente en la base de datos
        Ingrediente::create($validated);

        // 3. Notificar al componente de la lista para que se refresque
        $this->dispatch('ingrediente-refreshed');

        // Evento para cerrar el modal
        Flux::modals()->close();

        // 4. Limpiar el formulario.
        $this->reset(['name']);

    }
}; ?>

<form wire:submit="store" class="space-y-6">

    {{-- Input para el Nombre --}}
    <flux:input
        label="{{ __('Nombre') }}"
        placeholder="{{ __('Ej: Queso Mozzarella') }}"
        wire:model="name"
        :error="$errors->first('name')"
    />

    {{-- Botones de Acción --}}
    <div class="flex pt-4">
        <flux:spacer />

        <flux:button type="submit" variant="primary">
            {{ __('Guardar Ingrediente') }}
        </flux:button>
    </div>

</form>
