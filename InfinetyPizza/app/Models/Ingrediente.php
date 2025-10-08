<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    /** @use HasFactory<\Database\Factories\IngredienteFactory> */
    use HasFactory;

    protected $fillable = ['nombre'];

    /**
     * Un ingrediente pertenece a muchas pizzas.
     */
    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class);
    }
}
