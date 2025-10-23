<div
    x-data="{ show: false, msg: '', type: 'success' }"
    x-on:toast.window="
        msg = $event.detail.message;
        type = $event.detail.type ?? 'success';
        show = true;
        setTimeout(() => show = false, 2500);
    "
    class="fixed bottom-4 right-4 z-50"
>
    <div x-show="show" x-transition>
        {{-- Éxito --}}
        <template x-if="type === 'success'">
            <flux:callout variant="success" icon="check-circle" class="shadow-lg w-72">
                <flux:callout.heading x-text="msg"></flux:callout.heading>
            </flux:callout>
        </template>

        {{-- Error --}}
        <template x-if="type === 'error'">
            <flux:callout variant="danger" icon="x-circle" class="shadow-lg w-72">
                <flux:callout.heading x-text="msg"></flux:callout.heading>
            </flux:callout>
        </template>

        {{-- Información --}}
        <template x-if="type === 'info'">
            <flux:callout variant="secondary" icon="information-circle" class="shadow-lg w-72">
                <flux:callout.heading x-text="msg"></flux:callout.heading>
            </flux:callout>
        </template>
    </div>
</div>
