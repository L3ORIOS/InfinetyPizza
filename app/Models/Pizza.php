<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pizza extends Model
{
    /** @use HasFactory<\Database\Factories\PizzaFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price'
    ];

    /**
     * Una pizza tiene muchos ingredientes.
     */
    public function ingredientes(): BelongsToMany
    {
        return $this->belongsToMany(Ingrediente::class);
    }

    /**
     * Una pizza puede estar en muchos pedidos.
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
