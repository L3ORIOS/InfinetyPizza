<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard del administrador
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Crea esta vista
    })->name('admin.dashboard');

    // Rutas para la gestión de CRUDs (Pizzas, Ingredientes, etc.)
    // Route::resource('pizzas', App\Http\Controllers\PizzaController::class);
    // Route::resource('ingredientes', App\Http\Controllers\IngredienteController::class);
});
require __DIR__.'/auth.php';
