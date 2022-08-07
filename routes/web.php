<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[Frontend\WelcomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//rout frontend methods
Route::get('/categories', [Frontend\CategoryController::class , 'index'])->name('category.index');
Route::get('/categories/{category}', [Frontend\CategoryController::class , 'show'])->name('category.show');
Route::get('/menus', [Frontend\MenuController::class , 'index'])->name('menus.index');
Route::get('/reservation/stepOne', [Frontend\ReservationController::class , 'stepOne'])->name('reservations.step.one');
Route::get('/reservation/stepTwo', [Frontend\ReservationController::class , 'stepTwo'])->name('reservations.step.two');
Route::post('/reservation/storeStepOne', [Frontend\ReservationController::class , 'storeStepOne'])->name('reservations.store.step.one');
Route::post('/reservation/storeStepTwo', [Frontend\ReservationController::class , 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/thankyou', [Frontend\WelcomeController::class, 'thankyou'])->name('thankyou');

//route admin middleware

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function(){
    Route::get('/', [AdminController::class,'index'])->name('index');
    Route::resource('/menus',MenuController::class);
    Route::resource('/categories',CategoryController::class);
    Route::resource('/tables',TableController::class);
    Route::resource('/reservations',ReservationController::class);
    });

require __DIR__.'/auth.php';
