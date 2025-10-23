<div class="space-y-6">
    {{-- Encabezado --}}
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-semibold text-gray-500 dark:text-gray-100">
            {{ __('Listado de Pedidos') }}
        </h1>

    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-zinc-900 shadow sm:rounded-lg">
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-zinc-400">
                            {{ __('ID') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Cliente') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Pizza') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Fecha del pedido') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-zinc-400">
                            {{ __('Creado') }}
                        </th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                    @forelse ($pedidos as $pedido)
                        <tr wire:key="row-{{ $pedido->id }}">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                #{{ $pedido->id }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-gray-900 dark:text-gray-100 font-medium">
                                    {{ $pedido->user?->name ?? '—' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-zinc-400">
                                    {{ $pedido->user?->email ?? '' }}
                                </div>
                            </td>

                            <td class="px-4 py-3 text-gray-700 dark:text-zinc-300">
                                {{ $pedido->pizza?->name ?? '—' }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 dark:text-zinc-300">
                                @php
                                    $fh = $pedido->fecha_hora_pedido;
                                @endphp
                                {{ $fh ? \Illuminate\Support\Carbon::parse($fh)->format('d/m/Y H:i') : '—' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-zinc-400">
                                {{ $pedido->created_at?->diffForHumans() }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-zinc-500 dark:text-zinc-400" colspan="6">
                                {{ __('No hay pedidos registrados.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $pedidos->links() }}
            </div>
        </div>
    </div>
</div>
