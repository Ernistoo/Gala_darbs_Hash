<?php

use App\Models\User;
use Illuminate\Support\Facades\Event;

it('allows a user to log in with correct credentials', function () {

    // izveido lietotāju ar zināmu e-pastu un paroli
    $user = User::factory()->create([
        'email' => 'es@example.com',
        'password' => bcrypt('Example1@'),
    ]);

    // atver sākumlapu, dodas uz pieteikšanās formu un aizpilda to ar pareiziem datiem
    $page = visit('/')
        ->click('Login')
        ->assertSee('Email') // pārbauda vai redzams lauks "Email"
        ->fill('email', 'es@example.com')
        ->fill('password', 'Example1@')
        ->click('Log in') // nospiež pieteikšanās pogu
        ->waitForText('Dashboard', 10) // sagaida tekstu "Dashboard"
        ->assertSee($user->name ?? 'Dashboard'); // pārbauda, vai redzams lietotāja vārds vai "Dashboard"
});



it('shows an error when credentials are incorrect', function () {
    Event::fake();

    User::factory()->create([
        'email' => 'es@example.com',
        'password' => bcrypt('Example1@'),
    ]);

    $page = visit('/')
        ->click('Login')
        ->assertSee('Email')
        ->fill('email', 'es@example.com')
        ->fill('password', 'wrongPassword!')
        ->click('Log in')
        ->waitForText('These credentials do not match our records.', 10)
        ->assertSee('These credentials do not match our records.');
});


it('prevents login with non-existing user', function () {
    Event::fake();

    $page = visit('/')
        ->click('Login')
        ->assertSee('Email')
        ->fill('email', 'nonexistent@example.com')
        ->fill('password', 'Whatever123')
        ->click('Log in')
        ->waitForText('These credentials do not match our records.', 10)
        ->assertSee('These credentials do not match our records.');
});
