<x-mail::message>
# ¡Gracias por tu pedido, {{ $pedido->user->name }}!

Has solicitado la **{{ $pedido->pizza->name }}** por
**€ {{ number_format($pedido->pizza->price, 2) }}**.

---

### Ingredientes
@if($pedido->pizza->ingredientes->isEmpty())
—
@else
{{ $pedido->pizza->ingredientes->pluck('name')->implode(', ') }}
@endif

---

**Fecha y hora del pedido:**
{{ \Illuminate\Support\Carbon::parse($pedido->fecha_hora_pedido)->format('d/m/Y H:i') }}

<x-mail::button :url="config('app.url')">
Ver mi cuenta
</x-mail::button>

Gracias por elegirnos,
**Infinety Pizza**
{{ config('app.name') }}
</x-mail::message>
