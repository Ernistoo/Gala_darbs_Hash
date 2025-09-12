<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Kaķi', 'Mūzika', 'Māksla'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}