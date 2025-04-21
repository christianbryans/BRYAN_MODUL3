<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class EditNoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_edit_note()
    {
        // Setup: Buat user dan note miliknya
        $user = User::factory()->create([
            'name' => 'Dusk User',
            'email' => 'duskuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original Title',
            'description' => 'Original content',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            $browser->visit('http://127.0.0.1:8000/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOG IN')
                ->assertPathIs('/dashboard')

                // Navigasi ke Notes dan Edit Note
                ->clickLink('Notes')
                ->clickLink('Edit') // atau gunakan selector jika kamu pakai tombol per-note
                ->assertPathBeginsWith("/edit-note-page/{$note->id}")
                ->type('title', 'Dusk Test Note Updated')
                ->type('description', 'Updated content by Dusk test.')
                ->press('UPDATE')
                ->assertPathIs('/notes')
                ->assertSee('Dusk Test Note Updated')

                // Logout
                ->click('@user-dropdown')
                ->pause(300)
                ->click('@click-logout')
                ->pause(300)
                ->assertPathIs('/login'); // Sesuaikan jika setelah logout diarahkan ke '/' atau '/login'
        });
    }
}
