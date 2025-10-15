<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Ingrediente;
use App\Models\Pizza;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ingredientes = Ingrediente::all()->keyBy('name');

        $getIngrediente = fn ($name) => $ingredientes->get($name)?->id;

        $margarita = Pizza::create([
            'name' => 'Margarita',
            'description' => 'La clásica, fresca y sencilla',
            'price' => 12.50,
        ]);

        $margarita->ingredientes()->attach([
            $getIngrediente('Tomate'),
            $getIngrediente('Mozzarella'),
            $getIngrediente('Albahaca'),
            $getIngrediente('Oregano'),
        ]);

        $hawaiana = Pizza::create([
            'name' => 'Hawaiana',
            'description' => 'Una combinación dulce y salada',
            'price' => 14.00,
        ]);

        $hawaiana->ingredientes()->attach([
            $getIngrediente('Tomate'),
            $getIngrediente('Mozzarella'),
            $getIngrediente('Jamón'),
            $getIngrediente('Piña'),
        ]);

        $pepperoni = Pizza::create([
            'name' => 'Pepperoni',
            'description' => 'La favorita de muchos.',
            'price' => 15.75,
        ]);

        $pepperoni->ingredientes()->attach([
            $getIngrediente('Tomate'),
            $getIngrediente('Mozzarella'),
            $getIngrediente('Pepperoni'),
        ]);
    }
}
