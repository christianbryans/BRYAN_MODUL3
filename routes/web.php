<?php

// Import controller untuk mengelola data profil pengguna
use App\Http\Controllers\ProfileController;
// Import fasiltias Route dari Laravel
use Illuminate\Support\Facades\Route;
// Import controller untuk mengelola catatan (notes)
use App\Http\Controllers\NoteController;

// Route untuk halaman utama (/) yang akan menampilkan view 'welcome'
Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman dashboard (/dashboard)
// Hanya bisa diakses jika pengguna telah login dan email terverifikasi
// Nama route ini adalah 'dashboard'
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup route yang hanya bisa diakses oleh pengguna yang telah login
Route::middleware('auth')->group(function () {
    
    // Route untuk menampilkan halaman edit profil
    // Mengarah ke method 'edit' pada ProfileController
    // Nama route: 'profile.edit'
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Route untuk mengupdate data profil (menggunakan metode PATCH)
    // Mengarah ke method 'update' pada ProfileController
    // Nama route: 'profile.update'
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route untuk menghapus akun pengguna (menggunakan metode DELETE)
    // Mengarah ke method 'destroy' pada ProfileController
    // Nama route: 'profile.destroy'
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk menampilkan daftar catatan (notes)
    // Mengarah ke method 'index' pada NoteController
    // Nama route: 'notes'
    Route::get('/notes', [NoteController::class, 'index'])->name('notes');

    // Route untuk menampilkan halaman pembuatan catatan baru
    // Mengarah ke method 'create' pada NoteController
    Route::get('/create-note', [NoteController::class, 'create']);

    // Route untuk menyimpan data catatan baru (metode POST)
    // Mengarah ke method 'store' pada NoteController
    // Nama route: 'note-submit'
    Route::post('/submit-note', [NoteController::class, 'store'])->name('note-submit');

    // Route untuk menampilkan detail catatan berdasarkan ID
    // Mengarah ke method 'show' pada NoteController
    // Nama route: 'detail-note'
    Route::get('/note/{id}', [NoteController::class, 'show'])->name('detail-note');

    // Route untuk menampilkan halaman edit catatan berdasarkan ID
    // Mengarah ke method 'edit' pada NoteController
    Route::get('/edit-note-page/{id}', [NoteController::class, 'edit']);

    // Route untuk mengupdate catatan berdasarkan ID (metode PUT)
    // Mengarah ke method 'update' pada NoteController
    // Nama route: 'note-update'
    Route::put('/note-update/{id}', [NoteController::class, 'update'])->name('note-update');

    // Route untuk menghapus catatan berdasarkan ID (metode DELETE)
    // Mengarah ke method 'destroy' pada NoteController
    Route::delete('/delete-note/{id}', [NoteController::class, 'destroy']);
});

// Memuat file routes tambahan untuk proses autentikasi (login, register, dll)
require __DIR__.'/auth.php';
