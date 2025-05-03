<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\UserController as UserDashboardController;
use App\Http\Controllers\StoreManager\StoreDashboardController;
use App\Http\Controllers\StoreManager\ProductController as StoreManagerProductController;
use App\Http\Controllers\StoreManager\FeaturedProductController;
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

    Route::get('/', function () 
    {
        return view('layouts.boothome');
    })->name('home');

    Route::get('/welcome', function () 
    {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        // Add success message in the session
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }
        elseif(auth()->user()->role === 'store_manager') {
            return redirect()->route('store-manager.dashboard')->with('success', 'Login successful!');
        }
        return redirect()->route('user.dashboard')->with('success', 'Login successful!');
    })->middleware(['auth', 'verified'])->name('dashboard');
    

    Route::middleware(['auth', 'verified'])->group(function () 
    {
        Route::get('/user/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');

        Route::get('/user/products', [UserDashboardController::class, 'products'])->name('user.products');
        
        Route::get('/products/{id}', [UserDashboardController::class, 'productDetails'])->name('user.productdetails');
        Route::get('/user/featuredproducts', [UserDashboardController::class, 'featuredproducts'])->name('user.featuredproducts');
        Route::post('/submit-response', [UserDashboardController::class, 'storeResponse']);
        



        Route::get('/user/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
        Route::put('/user/profile', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
        
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () 
    {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware(['auth'])
            ->name('dashboard');
        
        // Stores management
        Route::resource('stores', StoreController::class);
        
        // Users management
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        
        // Products management
        Route::resource('products', AdminProductController::class);

        //Settings
        Route::resource('settings', SettingsController::class);
        
        // Routes for assigning users to stores
        Route::get('/stores/{store}/available-managers', [StoreController::class, 'getAvailableManagers']);
        Route::post('/stores/{store}/assign-user', [StoreController::class, 'assignUser']);
    });

    // Admin Questionnaire Routes
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () 
    {
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
    Route::middleware(['auth'])->group(function () 
    {
        Route::get('questionnaires', [App\Http\Controllers\QuestionnaireController::class, 'index'])->name('questionnaires.index');
        Route::get('questionnaires/{questionnaire}', [App\Http\Controllers\QuestionnaireController::class, 'show'])->name('questionnaires.show');
        Route::post('questionnaires/{questionnaire}/submit', [App\Http\Controllers\QuestionnaireController::class, 'submit'])->name('questionnaires.submit');
        Route::get('questionnaires/expertise', [App\Http\Controllers\QuestionnaireController::class, 'expertise'])->name('questionnaires.expertise');
        Route::post('questionnaires/expertise', [App\Http\Controllers\QuestionnaireController::class, 'submitExpertise'])->name('questionnaires.submit-expertise');
        Route::get('/get-questions/{id}', [App\Http\Controllers\QuestionnaireController::class, 'getQuestions']);

    });

    // Store Manager routes
    Route::prefix('store-manager')->name('store-manager.')->middleware(['auth', 'store.manager'])->group(function () {
        Route::get('/dashboard', [StoreDashboardController::class, 'index'])->name('dashboard');
        Route::get('/products', [StoreManagerProductController::class, 'index'])->name('products');
        Route::get('/products/{id}', [StoreManagerProductController::class, 'singleproduct'])->name('singleproduct');
        Route::get('/featuredproducts', [FeaturedProductController::class, 'index'])->name('featuredproducts');
        Route::get('/test', [StoreDashboardController::class, 'test'])->name('test');
        
    });

    // Add these routes for user product viewing
    Route::middleware(['auth'])->group(function () {
        // Product routes for regular users
        Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
        Route::get('/products/type/{type}', [App\Http\Controllers\ProductController::class, 'byType'])->name('products.type');
        
        // Store routes for regular users
        Route::get('/stores', [App\Http\Controllers\StoreController::class, 'index'])->name('stores.index');
        Route::get('/stores/{store}', [App\Http\Controllers\StoreController::class, 'show'])->name('stores.show');
    });

    require __DIR__.'/auth.php';
