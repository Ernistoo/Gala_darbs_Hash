<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{actingAs, post, assertDatabaseHas};

it('creates a new post successfully', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $category = Category::factory()->create();

    actingAs($user);

    $data = [
        'title' => 'My First Post',
        'content' => 'This is a test post created by Pest.',
        'category_id' => $category->id,
        'image' => UploadedFile::fake()->image('test.jpg'),
    ];

    $response = post(route('posts.store'), $data);

    $response->assertRedirect(route('posts.index'));

    assertDatabaseHas('posts', [
        'title' => 'My First Post',
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    Storage::disk('public')->assertExists('posts/' . $data['image']->hashName());
});
