<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/dashboard', function () {
    return view("dash.home.admin");
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Start of General Operations
Route::controller(App\Http\Controllers\GeneralOperationsController::class)->middleware(['auth','role:SuperAdmin'])->prefix('gn-operations')->group(function () {

    Route::prefix('business')->group(function (){

            Route::get('/create', 'createBusiness');
            Route::post('/create', 'storeBusiness')->name('business.create');
            Route::get('/retrieve', 'retrieveBusiness')->name('business.retrieve');
            Route::post('/fetch', 'fetchBusiness')->name('business.fetch');


});

});

// End of General Operations

Route::middleware(['auth','role:SuperAdmin'])->prefix('bk-operations')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

});

// Start of Bulk Opperatrions


// End of Bulk Operations

// Start of Internal Operations

Route::controller(App\Http\Controllers\InternalOperationsController::class)->middleware(['auth','role:SuperAdmin'])->prefix('in-operations')->group(function () {

    Route::prefix('pt-details')->group(function (){


            Route::get('/retrieve', 'retrievePT')->name('pt.retrieve');
            Route::post('/fetch', 'fetchPT')->name('pt.fetch');

    });

    Route::prefix('ab')->group(function (){


        Route::get('/whitelist', 'whitelist')->name('ap.whitelist');

        Route::post('/whitelist', 'PostWhitelist')->name('ab.whitelist.post');

        Route::get('/whitelist/retrieve', 'RetrieveWhitelist')->name('ap.whitelist.retrieve');



});

});

// End of Internal Operations



require __DIR__.'/auth.php';
