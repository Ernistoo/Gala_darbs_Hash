<?php

use App\Models\User;
use App\Models\Friendship;
use function Pest\Laravel\{actingAs, post};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows user to send friend requests', function () {
    $sender = User::factory()->create();
    $receiver = User::factory()->create();

    actingAs($sender)
        ->post(route('friends.send', $receiver))
        ->assertRedirect();

    expect(Friendship::where('user_id', $sender->id)
        ->where('friend_id', $receiver->id)
        ->where('status', 'pending')
        ->exists())->toBeTrue();
});


it('prevents user from adding themselves', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('friends.send', $user))
        ->assertRedirect()
        ->assertSessionHas('error', 'You cannot add yourself as a friend.');

    expect(Friendship::count())->toBe(0);
});


it('allows user to accept friend requests', function () {
    $sender = User::factory()->create();
    $receiver = User::factory()->create();

    $friendship = Friendship::create([
        'user_id' => $sender->id,
        'friend_id' => $receiver->id,
        'status' => 'pending',
    ]);

    actingAs($receiver)
        ->post(route('friends.accept', $friendship))
        ->assertRedirect();

    $friendship->refresh();
    expect($friendship->status)->toBe('accepted');
});


it('prevents users from accepting friend requests that are not sent to them', function () {
    $sender = User::factory()->create();
    $receiver = User::factory()->create();
    $intruder = User::factory()->create();

    $friendship = Friendship::create([
        'user_id' => $sender->id,
        'friend_id' => $receiver->id,
        'status' => 'pending',
    ]);

    actingAs($intruder)
        ->post(route('friends.accept', $friendship))
        ->assertStatus(403);
});
