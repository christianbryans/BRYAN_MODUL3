<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_logout()
    {
        // Buat user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => Hash::make('pass1234'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('http://127.0.0.1:8000/login')
                ->type('email', 'testuser@example.com')
                ->type('password', 'pass1234')
                ->press('LOG IN')
                ->assertPathIs('/dashboard')

                // Klik user dropdown
                ->click('@user-dropdown')
                ->pause(300)

                // Klik logout
                ->click('@click-logout')
                ->pause(500)

                // Pastikan kembali ke login (atau halaman setelah logout)
                ->assertPathIs('/login');
        });
    }
}
