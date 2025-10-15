<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{
    actingAs,
    post,
    assertDatabaseHas
};

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
    $this->category = Category::factory()->create();
});

it('creates a post successfully with image and youtube url', function () {
    // imitē lietotāja pieteikšanos sistēmā
    actingAs($this->user);

    // izveido testa datus jaunam ierakstam (ar attēlu un YouTube saiti)
    $data = [
        'title'       => 'A Post With Image',
        'content'     => 'This is a test post with image and YouTube URL.',
        'category_id' => $this->category->id,
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'image'       => UploadedFile::fake()->image('cover.jpg'), // Izmanto viltotu attēlu testam
    ];

    // nosūta POST pieprasījumu uz maršrutu, kas izveido jaunu ierakstu
    $response = post(route('posts.store'), $data);

    // pārbauda, vai pēc izveides lietotājs tiek pāradresēts uz ierakstu saraksta lapu
    $response->assertRedirect(route('posts.index'));

    // pārbauda, vai datubāzē ir izveidots ieraksts ar pareizajiem datiem
    assertDatabaseHas('posts', [
        'title' => 'A Post With Image',
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    // pārbauda, vai attēls ir saglabājies publiskajā diska mapē
    Storage::disk('public')->assertExists('posts/' . $data['image']->hashName());
});


it('creates a post successfully without image', function () {
    actingAs($this->user);

    $data = [
        'title'       => 'A Post Without Image',
        'content'     => 'Testing post creation without image.',
        'category_id' => $this->category->id,
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    ];

    $response = post(route('posts.store'), $data);

    $response->assertRedirect(route('posts.index'));

    assertDatabaseHas('posts', [
        'title' => 'A Post Without Image',
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    Storage::disk('public')->assertMissing('posts/');
});

it('fails to create a post without title', function () {
    actingAs($this->user);

    $data = [
        'title'       => '',
        'content'     => 'Missing title test.',
        'category_id' => $this->category->id,
    ];

    $response = post(route('posts.store'), $data);

    $response->assertSessionHasErrors(['title']);
});
