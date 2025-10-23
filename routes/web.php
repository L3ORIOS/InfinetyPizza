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


    Volt::route('ingredientes', 'admin.ingredientes.index')->name('admin.ingredientes.index');

    Route::get('/pizzas', \App\Livewire\Admin\Pizzas\Index::class)->name('admin.pizzas.index');
    Route::get('/pizzas/nueva', \App\Livewire\Admin\Pizzas\Form::class)->name('admin.pizzas.create');
    Route::get('/pizzas/{pizza}/editar', \App\Livewire\Admin\Pizzas\Form::class)->name('admin.pizzas.edit');


});
require __DIR__.'/auth.php';
