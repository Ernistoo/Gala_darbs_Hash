<?php

use App\Models\User;
use App\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{actingAs, post};

uses(RefreshDatabase::class);

it('allows authenticated user to create a collection', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $image = UploadedFile::fake()->image('collection.jpg');

    actingAs($user)
        ->post(route('collections.store'), [
            'name' => 'My Cool Collection',
            'description' => 'A description for testing',
            'image' => $image,
        ])
        ->assertRedirect();

    $collection = Collection::first();

    expect($collection)
        ->not->toBeNull()
        ->and($collection->name)->toBe('My Cool Collection')
        ->and($collection->user_id)->toBe($user->id);

    Storage::disk('public')->assertExists($collection->image);
});


it('requires a name when creating a collection', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('collections.store'), [
            'description' => 'No name field here',
        ])
        ->assertSessionHasErrors(['name']);
});
