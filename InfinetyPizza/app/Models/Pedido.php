<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;

     protected $fillable = [
        'user_id',
        'pizza_id',
        'fecha_hora_pedido',
    ];

    protected $casts = [
        'fecha_hora_pedido' => 'datetime',
    ];

    /**
     * Un pedido pertenece a un usuario (cliente).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un pedido se realiza para una única pizza.
     */
    public function pizza(): BelongsTo
    {
        return $this->belongsTo(Pizza::class);
    }
}
