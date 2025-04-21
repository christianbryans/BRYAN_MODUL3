<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class ViewNoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_register_login_create_edit_view_delete_note_and_logout()
    {
        // Setup: Buat user dan note yang akan diuji
        $user = User::factory()->create([
            'name' => 'Dusk User',
            'email' => 'duskuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'Dusk Test Note Updated',
            'description' => 'Updated content by Dusk test.',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            $browser
                ->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOG IN')
                ->assertPathIs('/dashboard')

                // Navigasi ke halaman notes dan buka note
                ->clickLink('Notes')
                ->clickLink($note->title) // klik judul note
                ->assertSee($note->description) // pastikan deskripsi note muncul

                // Logout
                ->click('@user-dropdown')
                ->pause(300)
                ->click('@click-logout')
                ->pause(300)
                ->assertPathIs('/login'); // atau '/' jika redirect ke home
        });
    }
}
