<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','verified',\App\Http\Middleware\PhoneVerify::class])->group(function () {
    Route::get('/dashboard', [\App\Livewire\AdminDashboard::class,'render'])->name('dashboard');

    Route::get('/account-list', [\App\Livewire\AccountList::class,'render'])->name('account.list');
    Route::get('/fund-transfer', [\App\Livewire\FundTransfer::class,'render'])->name('fund.transfer');

    Route::post('/create-account',[\App\Livewire\AdminDashboard::class,'create'])->name('create.account');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__.'/auth.php';
