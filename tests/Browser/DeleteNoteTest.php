<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteNoteTest extends DuskTestCase
{
    use DatabaseMigrations; // Pastikan database reset agar test konsisten

    /**
     * A Dusk test for deleting a note.
     */
    public function testUserCanDeleteNote(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/login') // Kunjungi halaman login
                ->type('email', 'duskuser@example.com') // Isi email
                ->type('password', 'password') // Isi password
                ->press('LOG IN') // Tekan tombol login
                ->assertPathIs('/dashboard') // Pastikan berhasil login

                ->clickLink('Notes') // Navigasi ke halaman Notes
                ->waitForLocation('/notes') // Tunggu sampai halaman notes terbuka
                ->pause(1000) // (Opsional) Tunggu untuk pastikan data terload

                ->click('delete') // Klik tombol delete untuk note dengan ID 5
                ->waitForText('Note has been deleted') // Tunggu munculnya notifikasi
                ->assertSee('Note has been deleted') // Verifikasi pesan sukses

                ->press('Dusk User') // Buka dropdown user
                ->clickLink('Log Out') // Klik logout
                ->assertPathIs('/'); // Pastikan berhasil logout
        });
    }
}
