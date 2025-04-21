<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Str;

class RegistrasiTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test form registrasi.
     */
    public function testUserCanRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/register')
                    ->assertPathIs('/register')
                    ->type('name', 'Test User')
                    ->type('email', 'testuser' . Str::random(5) . '@example.com') // random email untuk hindari duplicate
                    ->type('password', 'pass1234')
                    ->type('password_confirmation', 'pass1234')
                    ->press('REGISTER'); // pastikan sesuai teks di tombol
        });
    }
}
