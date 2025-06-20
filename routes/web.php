<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\IsFeaturedController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\UserController as UserDashboardController;
use App\Http\Controllers\StoreManager\StoreDashboardController;
use App\Http\Controllers\StoreManager\ProductController as StoreManagerProductController;
use App\Http\Controllers\StoreManager\FeaturedProductController;
use App\Http\Controllers\MainManagerController;
use App\Http\Controllers\StoreAssignmentController;
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
        elseif (auth()->user()->role === 'main_manager') {
            return redirect()->route('main-manager.dashboard')->with('success', 'Login successful!');
        }
        return redirect()->route('user.dashboard')->with('success', 'Login successful!');
    })->middleware(['auth', 'verified'])->name('dashboard');
    

    Route::middleware(['auth', 'verified'])->group(function () 
    {
        Route::get('/user/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');

        Route::get('/user/products', [UserDashboardController::class, 'products'])->name('user.products');
        Route::get('user/matched-products/{submissionId}', [UserDashboardController::class, 'matchedproducts'])->name('user.matchedproducts');

        Route::post('/user/cart/add', [UserDashboardController::class, 'addToCart'])->name('user.cart.add');
        Route::post('/user/cart/remove', [UserDashboardController::class, 'removeFromCart'])->name('user.cart.remove');
        Route::get('/user/cart', [UserDashboardController::class, 'getCart'])->name('user.cart.get');
        Route::post('/user/checkout', [UserDashboardController::class, 'checkout'])->name('user.checkout');



        Route::get('/products/{id}', [UserDashboardController::class, 'productDetails'])->name('user.productdetails');
        Route::get('/user/featuredproducts', [UserDashboardController::class, 'featuredproducts'])->name('user.featuredproducts');
        Route::get('/user/showQuestionnaire', [UserDashboardController::class, 'userquestionnaire'])->name('user.showQuestionnaire');
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

        //is_featured_products
        Route::get('/is-featured-products', [IsFeaturedController::class, 'index'])->name('isFeatured.index');
        Route::get('/is-featured-products/{store_id}', [IsFeaturedController::class, 'show'])->name('isFeatured.show');

        //Questionnaire-Response page 
        // Page showing all submissions
        Route::get('/questionnaire/responses', [QuestionnaireController::class, 'showRespnses'])->name('questionnaire.responses');

        // View individual submission details
        Route::get('/questionnaire/responses/{submission_id}', [QuestionnaireController::class, 'showIndividualResponses'])->name('questionnaire.responses.show');

        //Main Manager route
        Route::get('/main-manager', [MainManagerController::class, 'index'])->name('main_manager');
        Route::post('/main-manager/create', [MainManagerController::class, 'store'])->name('main_manager.store');
    
        //assign stores to manager
        Route::get('/assign-stores/{manager}', [StoreAssignmentController::class, 'edit'])->name('assign.stores');
        Route::post('/assign-stores/{manager}', [StoreAssignmentController::class, 'update'])->name('assign.stores.update');


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
        Route::get('/test', [StoreDashboardController::class, 'test'])->name('test');
        Route::post('/products/update-status', [StoreManagerProductController::class, 'updateStatus']);
        Route::post('/products/update-featured', [StoreManagerProductController::class, 'updateFeatured']);

        
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


    //main manager routes
    Route::middleware(['auth', 'main.manager'])->group(function () {
        Route::get('/main-manager/dashboard', [MainManagerController::class, 'dashboard'])->name('main-manager.dashboard');
        Route::get('/main-manager/stores', [MainManagerController::class, 'MainManagerAllStores'])->name('main-manager.allStores');
        Route::get('/manager/store-details/{storeId}', [MainManagerController::class, 'getStoreDetails'])->name('manager.store.details');


    });
    


    require __DIR__.'/auth.php';
