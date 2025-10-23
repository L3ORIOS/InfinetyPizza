<div class="space-y-6">
    <form wire:submit.prevent="save" class="space-y-4">
        <flux:input
            label="{{ $editMode ? __('Nombre de la pizza') : __('Nombre de la pizza') }}"
            wire:model.defer="name"
            :error="$errors->first('name')"
            autofocus
        />

        <flux:textarea
            label="{{ __('Descripción') }}"
            wire:model.defer="description"
            :error="$errors->first('description')"
            rows="3"
        />

        <flux:input
            type="number"
            step="0.01"
            label="{{ __('Precio (€)') }}"
            wire:model.defer="price"
            :error="$errors->first('price')"
        />

        {{-- lista de checkboxes --}}
        <div class="space-y-2">
            <div class="text-sm font-medium">{{ __('Ingredientes') }}</div>
            <div class="grid sm:grid-cols-2 gap-2">
                @foreach($ingredientes as $ing)
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:model="ingredientesSeleccionados"
                            value="{{ $ing->id }}"
                            class="rounded border-gray-300"
                        >
                        <span>{{ $ing->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('ingredientesSeleccionados.*')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex pt-4">
            <flux:spacer />
            <flux:button type="submit" variant="primary">
                {{ $editMode ? __('Guardar cambios') : __('Crear pizza') }}
            </flux:button>
        </div>
    </form>
</div>
