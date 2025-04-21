<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test user can login.
     */
    public function testUserCanLogin(): void
    {
        // Buat user dulu di database
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => Hash::make('pass1234'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('http://127.0.0.1:8000/login')
                    ->assertPathIs('/login')
                    ->type('email', 'testuser@example.com')
                    ->type('password', 'pass1234')
                    ->press('LOG IN'); // sesuai dengan isi <x-primary-button>
        });
    }
}
