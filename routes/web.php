<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/welcome', function () {
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

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');
    
    // Stores management
    Route::resource('stores', StoreController::class);
    
    // Users management
    Route::resource('users', UserController::class);
    
    // Products management
    Route::resource('products', ProductController::class);
});

// Admin Questionnaire Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('questionnaires', [App\Http\Controllers\Admin\QuestionnaireController::class, 'index'])->name('questionnaires.index');
    Route::get('questionnaires/create', [App\Http\Controllers\Admin\QuestionnaireController::class, 'create'])->name('questionnaires.create');
    Route::post('questionnaires', [App\Http\Controllers\Admin\QuestionnaireController::class, 'store'])->name('questionnaires.store');
    Route::get('questionnaires/{questionnaire}', [App\Http\Controllers\Admin\QuestionnaireController::class, 'show'])->name('questionnaires.show');
    Route::get('questionnaires/{questionnaire}/edit', [App\Http\Controllers\Admin\QuestionnaireController::class, 'edit'])->name('questionnaires.edit');
    Route::put('questionnaires/{questionnaire}', [App\Http\Controllers\Admin\QuestionnaireController::class, 'update'])->name('questionnaires.update');
    Route::delete('questionnaires/{questionnaire}', [App\Http\Controllers\Admin\QuestionnaireController::class, 'destroy'])->name('questionnaires.destroy');
    Route::put('questionnaires/{questionnaire}/toggle-status', [App\Http\Controllers\Admin\QuestionnaireController::class, 'toggleStatus'])->name('questionnaires.toggle-status');
    Route::get('questionnaire-analytics', [App\Http\Controllers\Admin\QuestionnaireController::class, 'analytics'])->name('questionnaires.analytics');
});

// User Questionnaire Routes
Route::get('questionnaires', [App\Http\Controllers\QuestionnaireController::class, 'index'])->name('questionnaires.index');
Route::get('questionnaires/{questionnaire}', [App\Http\Controllers\QuestionnaireController::class, 'show'])->name('questionnaires.show');
Route::post('questionnaires/{questionnaire}/submit', [App\Http\Controllers\QuestionnaireController::class, 'submit'])->name('questionnaires.submit');

// Store Manager routes
Route::prefix('store-manager')->name('store-manager.')->middleware(['auth', 'store.manager'])->group(function () {
});

require __DIR__.'/auth.php';
