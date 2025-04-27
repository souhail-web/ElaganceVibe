<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\SettingsController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Souhail est ajouté cette partie🐱‍👤
Route::middleware(['auth','admin'])->group(function (){

    Route::get('admin/dashboard',[HomeController::class, 'index'])->name('dashboard');

    Route::get('admin/products',[ProductController::class, 'index'])->name('admin/products');

    Route::get('admin/users',[UsersController::class, 'index'])->name('admin/users');

    Route::get('admin/income',[IncomeController::class, 'index'])->name('admin/income');

    Route::get('admin/settings',[SettingsController::class, 'index'])->name('admin/settings');
});

require __DIR__.'/auth.php';

//khaliw had les liens hna merci👀
//Route::get('admin/dashboard',[HomeController::class, 'index']);
//Route::get('admin/dashboard',[HomeController::class, 'index'])->middleware(['auth','admin']);