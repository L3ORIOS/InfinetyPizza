<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Ingrediente;

class IngredienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredientes = [
            'Mozzarella', 'Tomate',
            'Pepperoni', 'Piña',
            'Jamón', 'Albahaca',
            'Oregano',
        ];

        foreach ($ingredientes as $name) {
            # code...
            Ingrediente::firstOrCreate(['name' => $name]);
        }
    }
}
