<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Informatique',
            'description' => 'Ordinateurs et périphériques',
        ]);

        Category::create([
            'name' => 'Gaming',
            'description' => 'Matériel dédié au jeu vidéo',
        ]);

        Category::create([
            'name' => 'Audio',
            'description' => 'Casques et enceintes',
        ]);

        Category::create([
            'name' => 'Smartphones',
            'description' => 'Téléphones et accessoires mobiles',
        ]);

        Category::create([
            'name' => 'Accessoires',
            'description' => 'Câbles et adaptateurs',
        ]);
    }
}