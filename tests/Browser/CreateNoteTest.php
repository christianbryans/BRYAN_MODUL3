<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class CreateNoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_note()
    {
        // Buat user
        $user = User::factory()->create([
            'name' => 'Dusk User',
            'email' => 'duskuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('http://127.0.0.1:8000/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOG IN')
                ->assertPathIs('/dashboard')

                // Akses halaman Notes dan Create Note
                ->clickLink('Notes')
                ->clickLink('Create Note')
                ->assertPathIs('/create-note')
                ->type('title', 'Dusk Test Note')
                ->type('description', 'This is a note created by Laravel Dusk test.')
                ->press('CREATE')
                ->assertSee('Dusk Test Note')

                // Klik dropdown dan logout
                ->click('@user-dropdown')
                ->pause(300)
                ->click('@click-logout')
                ->pause(300)
                ->assertPathIs('/login');
        });
    }
}
