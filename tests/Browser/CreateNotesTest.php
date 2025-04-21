<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class CreateNotesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test user can create a note.
     */
    public function testUserCanCreateNote(): void
    {
        // Buat user
        $user = User::factory()->create([
            'email' => 'noteuser@example.com',
            'password' => Hash::make('pass1234'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('http://127.0.0.1:8000/create-note')
                    ->assertPathIs('/create-note')
                    ->type('title', 'Catatan Dusk')
                    ->type('description', 'Ini adalah deskripsi catatan yang dibuat lewat test Dusk.')
                    ->press('Create')
                    ->assertPathIs('/notes') // asumsi redirect ke /notes setelah berhasil
                    ->assertSee('success');  // pastikan notifikasi tampil (bisa disesuaikan dengan isi notifikasi)
        });
    }
}
