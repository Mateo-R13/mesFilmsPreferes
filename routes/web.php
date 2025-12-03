<?php

use App\Http\Controllers\AmisController;
use App\Http\Controllers\ConnexionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(FavorisController::class)->group(function () {
    Route::get('/favoris', 'index')->name('favoris');
    Route::post('/favoris/ajouter', 'store')->name('favoris.add');
    Route::post('/favoris/{favori}', 'destroy')->name('favoris.destroy');
    Route::post('/favoris/{favoris}/avis', 'updateAvis')->name('favoris.updateAvis');
});

Route::controller(AmisController::class)->group(function () {
    Route::get('/amis', 'index')->name('amis');
    Route::post('/amis/ajouter', 'ajout')->name('amis.add');
    Route::get('/amis/{ami}', 'afficher')->name('amis.print');
    Route::post('/amis/{ami}/supprimer', 'supprimer')->name('amis.delete');
});
Route::controller(CompteController::class)->group(function () {
    Route::get('/profile', 'afficher')->name('profile.edit');
    Route::patch('/profile', 'modifier')->name('profile.update');
    Route::delete('/profile', 'supprimer')->name('profile.destroy');
});
Route::controller(ConnexionController::class)->group(function () {
    Route::get('/login', 'afficherFormulaireConnexion')->name('login');
    Route::post('/login', 'traiterConnexion')->name('login.process');
    Route::post('/logout', 'deconnecter')->name('logout');
    Route::get('/register', 'afficherFormulaireInscription')->name('register');
    Route::post('/register', 'traiterInscription')->name('register.process');
});