<?php

use Livewire\Volt\Component;
use App\Models\Ingrediente;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;

new class extends Component {
    //
    // Si es null => crear; si tiene id => editar
    public ?int $ingredienteId = null;

    #[Validate(as: 'Ingrediente')]
    public string $name = '';

    // Carga inicial (si viene id, se trata de edición)
    public function mount(?int $ingredienteId = null): void
    {
        $this->ingredienteId = $ingredienteId;

        if ($this->ingredienteId) {
            $ing = Ingrediente::findOrFail($this->ingredienteId);
            $this->name = $ing->name;
        }
    }

    public function rules(): array
    {
        // Unique en ingredientes.name, ignorando el actual si es edición
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('ingredientes', 'name')->ignore($this->ingredienteId),
            ],
        ];
    }

    // Crear o actualizar
    public function save(): void
    {
        $validated = $this->validate(
            $this->rules(), // Argumento 1: Pasamos las reglas explícitamente
            [
                'name.required' => 'El :attribute es obligatorio.',
                'name.string'   => 'El :attribute debe ser una cadena de texto.',
                'name.min'      => 'El :attribute debe tener al menos :min caracteres.',
                'name.max'      => 'El :attribute no puede superar los :max caracteres.',
                'name.unique'   => 'El :attribute ya ha sido registrado.',
            ]
        );

        if ($this->ingredienteId) {
            Ingrediente::findOrFail($this->ingredienteId)
                ->update(['name' => $this->name]);

            // avisa al padre
            $this->dispatch('ingrediente-refreshed');
            $this->dispatch('toast', message: 'Ingrediente editado correctamente.', type: 'success');
            $this->reset('name');
            Flux::modals()->close();

        } else {
            Ingrediente::create(['name' => $this->name]);
            $this->dispatch('ingrediente-refreshed');
            $this->reset('name');
            $this->dispatch('toast', message: 'Ingrediente guardado correctamente.', type: 'success');
            Flux::modals()->close();
        }
    }
}; ?>

<form wire:submit.prevent="save" class="space-y-4">

    <flux:input
        label="{{ $ingredienteId ? 'Editar nombre' : 'Nombre del ingrediente' }}"
        placeholder="Ej. Queso mozzarella"
        wire:model.defer="name"
        :error="$errors->first('name')"
        autofocus
    />

    <div class="flex pt-4">
        <flux:spacer />
        <flux:button type="submit" variant="primary">
            {{ $ingredienteId ? __('Guardar cambios') : __('Crear ingrediente') }}
        </flux:button>
    </div>

</form>
