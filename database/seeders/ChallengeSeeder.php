<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        Challenge::create([
            'title' => 'Apraksti savu vasaru viena bilde',
            'description' => 'Ievieto bildi, kas vislabāk raksturo tavu vasaru.'
        ]);

        Challenge::create([
            'title' => 'Parādi savu dīvaināko apģērba gabalu',
            'description' => 'Ievieto bildi ar apģērbu, kas ir visdīvainākais tavā skapī.'
        ]);

        Challenge::create([
            'title' => 'Ieliec savu smukāko bildi ar savu mīļāko dzīvnieku',
            'description' => 'Ievieto bildi ar savu mīļāko dzīvnieku, kur tu esi kopā ar viņu.'
        ]);
    }
}
