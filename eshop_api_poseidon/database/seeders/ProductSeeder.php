<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'category_id' => 1, // Informatique
            'name' => 'Clavier mécanique',
            'description' => 'Clavier RGB pour le développement et le jeu',
            'price' => 89.90,
            'stock' => 15,
        ]);

        Product::create([
            'category_id' => 1, // Informatique
            'name' => 'Souris sans fil',
            'description' => 'Souris ergonomique haute précision',
            'price' => 39.90,
            'stock' => 25,
        ]);

        Product::create([
            'category_id' => 2, // Gaming
            'name' => 'Manette PC/Console',
            'description' => 'Manette sans fil avec retour haptique',
            'price' => 59.90,
            'stock' => 10,
        ]);
    }
}