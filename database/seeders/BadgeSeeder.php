<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Badge::firstOrCreate(
            ['name' => 'Pirmais ieraksts!'],
            [
                'image' => 'first-post.png',
                'description' => 'Izveidoji savu pirmo kolekciju!'
            ]
        );

        Badge::firstOrCreate(
            ['name' => '100 like!'],
            [
                'image' => 'likes.png',
                'description' => 'Sasniedzi 100 like vienā postā!'
            ]
        );

        Badge::firstOrCreate(
            ['name' => 'Aktīvākais fotogrāfs augustā'],
            [
                'image' => 'photographer.png',
                'description' => 'Visvairāk bildes augustā!'
            ]
        );
    }
}
