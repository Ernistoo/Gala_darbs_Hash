<?php

use App\Models\User;

it('may sign in the user', function () {
    Event::fake();
 
    User::factory()->create([
        'email' => 'es@example.com',
        'password' => 'Example1@',
    ]);
 
    $page = visit('/');
    $page->click('Login')
         ->assertSee('Email')
         ->fill('email', 'es@example.com')
         ->fill('password', 'Example1@')
         ->click('Log in')
         ->waitForText('Dashboard', 5);
 
});