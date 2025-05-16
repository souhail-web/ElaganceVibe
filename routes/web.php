<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AppointmentController;





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

    Route::get('admin/dashboard',[HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/products',[ProductController::class, 'index'])->name('admin.products');
    Route::get('admin/users',[UsersController::class, 'index'])->name('admin.users');
    Route::get('admin/income',[IncomeController::class, 'index'])->name('admin.income');
    Route::get('admin/orders',[OrdersController::class, 'index'])->name('admin.orders');
    Route::get('admin/services',[ServicesController::class, 'index'])->name('admin.services');
    Route::get('admin/appointment',[AppointmentController::class, 'index'])->name('admin.appointment');

    // 🛠 Routes pour modifier et supprimer un rendez-vous
    Route::get('admin/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('admin.appointment.edit');
    Route::put('admin/appointments/{id}', [AppointmentController::class, 'update'])->name('admin.appointment.update');
    Route::delete('admin/appointments/{id}', [AppointmentController::class, 'destroy'])->name('admin.appointment.destroy');

    // 🛠 Routes pour modifier et supprimer un commande
    Route::delete('admin/orders/{order}', [OrdersController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('admin/orders/{order}/edit', [OrdersController::class, 'edit'])->name('admin.orders.edit');
    Route::put('admin/orders/{order}', [OrdersController::class, 'update'])->name('admin.orders.update');


    // 🛠 Routes pour modifier et supprimer un utilisateur
    Route::get('admin/users/{id}/edit', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [UsersController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/create', [UsersController::class, 'create'])->name('admin.users.create_employee');
    Route::post('/admin/users', [UsersController::class, 'store'])->name('admin.users.store');

    // 🛠 Routes CRUD pour les produits
    Route::get('admin/products/create', [ProductController::class, 'create'])->name('admin.products.create_product');
    Route::post('admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

});

require __DIR__.'/auth.php';

//khaliw had les liens hna merci👀
//Route::get('admin/dashboard',[HomeController::class, 'index']);
//Route::get('admin/dashboard',[HomeController::class, 'index'])->middleware(['auth','admin']);