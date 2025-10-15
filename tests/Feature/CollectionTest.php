<?php

use App\Models\User;
use App\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{actingAs, post};

uses(RefreshDatabase::class);
it('allows authenticated user to create a collection', function () {
    Storage::fake('public'); // izmanto neistu disku, lai netiktu rakstīts īsts fails

    $user = User::factory()->create(); // izveido testam jaunu lietotāju
    $image = UploadedFile::fake()->image('collection.jpg'); // izveido viltotu attēlu, kas imitē augšupielādi

    actingAs($user) // pieslēdz testu kā autentificētu lietotāju
        ->post(route('collections.store'), [ // vērtības parametriem
            'name' => 'My Cool Collection',
            'description' => 'A description for testing',
            'image' => $image,
        ])
        ->assertRedirect(); 

    $collection = Collection::first(); // pārbauda, vai datubāzē izveidota jauna kolekcija

    expect($collection) // pārbaudes par datiem datubāzē
        ->not->toBeNull() 
        ->and($collection->name)->toBe('My Cool Collection') 
        ->and($collection->user_id)->toBe($user->id); 

    Storage::disk('public')->assertExists($collection->image); // pārbauda, ka augšupielādētais fails saglabājies
});


it('requires a name when creating a collection', function () {
    $user = User::factory()->create(); // izveido lietotāju testam

    actingAs($user)
        ->post(route('collections.store'), [ // mēģina izveidot kolekciju bez nosaukuma
            'description' => 'No name field here',
        ])
        ->assertSessionHasErrors(['name']); // sagaida validācijas kļūdu par “name” lauku
});
