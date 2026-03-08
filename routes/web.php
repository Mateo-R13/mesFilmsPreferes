<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\AmisController;
use App\Http\Controllers\PartagesController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\ProfilController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes d'authentification (pour utilisateurs non connectés)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'createUser'])->name('register.store');
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
});

// Routes protégées (pour utilisateurs connectés)
Route::middleware('auth')->group(function () {
    // Déconnexion
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Films (recherche + détail TMDB)
    Route::controller(FilmsController::class)->group(function () {
        Route::get('/films/rechercher', 'search')->name('films.search');
        Route::get('/films/{tmdbId}', 'show')->name('films.show');
        Route::post('/films/ajouter-favori', 'addFavori')->name('films.addFavori');
    });

    // Favoris
    Route::controller(FavorisController::class)->group(function () {
        Route::get('/favoris', 'index')->name('favoris');
        Route::post('/favoris/ajouter', 'store')->name('favoris.add');
        Route::post('/favoris/{favori}', 'destroy')->name('favoris.destroy');
    });

    // Avis
    Route::controller(AvisController::class)->group(function () {
        Route::post('/avis/{favori}', 'store')->name('avis.add');
        Route::post('/avis/{avis}/update', 'update')->name('avis.update');
        Route::post('/avis/{avis}/delete', 'destroy')->name('avis.destroy');
    });

    // Amis
    Route::controller(AmisController::class)->group(function () {
        Route::get('/amis', 'index')->name('amis');
        Route::post('/amis/{user}/ajouter', 'add')->name('amis.add');
        Route::post('/amis/{user}/retirer', 'remove')->name('amis.remove');
    });

    // Partages
    Route::controller(PartagesController::class)->group(function () {
        Route::get('/partages', 'index')->name('partages');
        Route::post('/partages/ajouter', 'store')->name('partages.add');
    });

    // Profil
    Route::controller(ProfilController::class)->group(function () {
        Route::get('/profil', 'show')->name('profil');
        Route::get('/profil/edit', 'edit')->name('profil.edit');
        Route::post('/profil/update', 'update')->name('profil.update');
        Route::get('/profil/{user}', 'showAmi')->name('profil.ami'); // 👥 Profil public d'un ami
    });
});
