<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\IsFeaturedController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController as UserDashboardController;
use App\Http\Controllers\StoreManager\StoreDashboardController;
use App\Http\Controllers\StoreManager\StoreManagerCheeseProductController;
use App\Http\Controllers\StoreManager\ProductController as StoreManagerProductController;
use App\Http\Controllers\StoreManager\FeaturedProductController;
use App\Http\Controllers\MainManagerController;
use App\Http\Controllers\StoreAssignmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\TemplateController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\StoreProfileController;
use App\Http\Controllers\Api\UploadApiController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\StoreAnalyticsController;

use Illuminate\Support\Facades\Log;

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
    // Get 5 random featured products
    $featuredProducts = Product::where('admin_featured_product', true)
        ->inRandomOrder()
        ->take(5)
        ->get();

    return view('layouts.boothome', compact('featuredProducts'));
})->name('home');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/browse', [ProductController::class, 'browse'])->name('homeBrowseWines');
Route::get('/allcheese', [ProductController::class, 'allcheese'])->name('allcheese');


Route::get('/careers', function () {
    return view('careers');
})->name('careers');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter')->withoutMiddleware(['auth', 'verified']);

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/dashboard', function () {
    // Add success message in the session
    if (auth()->user()->role === 'admin' || auth()->user()->role === 'sub_admin') {
        return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
    } elseif (auth()->user()->role === 'store_manager') {
        return redirect()->route('store-manager.dashboard')->with('success', 'Login successful!');
    } elseif (auth()->user()->role === 'main_manager') {
        return redirect()->route('main-manager.dashboard')->with('success', 'Login successful!');
    }
    return redirect()->route('user.dashboard')->with('success', 'Login successful!');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public routes
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');

    Route::get('/user/products', [UserDashboardController::class, 'products'])->name('user.products');

    // Cheese Products Routes
    Route::get('/user/cheeses', [\App\Http\Controllers\User\CheeseProductController::class, 'index'])->name('user.cheeses');
    Route::get('/user/cheeses/{id}', [\App\Http\Controllers\User\CheeseProductController::class, 'show'])->name('user.cheese.show');
    Route::get('user/matched-products/{submissionId}', [UserDashboardController::class, 'matchedproducts'])->name('user.matchedproducts');

    Route::post('/user/cart/add', [UserDashboardController::class, 'addToCart'])->name('user.cart.add');
    Route::post('/user/cart/remove', [UserDashboardController::class, 'removeFromCart'])->name('user.cart.remove');
    Route::get('/user/cart', [UserDashboardController::class, 'getCart'])->name('user.cart.get');
    Route::post('/user/checkout', [UserDashboardController::class, 'checkout'])->name('user.checkout');

    Route::get('/products/{id}', [UserDashboardController::class, 'productDetails'])->name('user.productdetails');
    Route::get('/product-modal/{id}',[UserDashboardController::class, 'productModal'])->name('user.product.modal');
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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');

    // Stores management
    Route::resource('stores', StoreController::class);

    //Create SubAdmin
    Route::post('users/create-adming', [UserController::class, 'AdminCreate'])->name('users.admincreate');

    //SubAdmin Routes
    Route::get('/admin/subadmin', [SubAdminController::class, 'index'])->name('subadmin.home');
    Route::get('/admin/subadmin/{id}/features',[SubAdminController::class, 'edit'])->name('subadmin.features.edit');
    Route::post('/admin/subadmin/{id}/features',[SubAdminController::class, 'update'])->name('subadmin.features.update');



    Route::get('/users/loginhistory', [UserController::class, 'loginhistory'])->name('users.loginhistory');

    // Users management
    Route::resource('users', UserController::class);
    Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    

    //API routes
    Route::get('/api-master-data', [UploadApiController::class, 'productMaster'])
    ->name('api.master.data');

    Route::get('/api-stock-data', [UploadApiController::class, 'productStock'])
        ->name('api.stock.data');
    
    Route::post('/api-master-data/pull', [UploadApiController::class, 'pullProductMaster'])
        ->name('api.master.pull');
    
    Route::post('/api-stock-data/pull', [UploadApiController::class, 'pullProductStock'])
        ->name('api.stock.pull');


    //bulk upload

    Route::get('products/bulk-upload', [AdminProductController::class, 'bulkUploadForm'])
    ->name('products.bulk-upload');

    Route::post('products/bulk-upload', [AdminProductController::class, 'bulkUploadStore'])
        ->name('products.bulk-upload.store');

    Route::get('/products/download', [AdminProductController::class, 'downloadCSV'])->name('products.download');

    Route::post('/products/upload', [AdminProductController::class, 'uploadCSV'])->name('products.upload');

    Route::get('/invoice-uploads', [AdminProductController::class, 'invoiceUploads'])->name('invoice.uploads');
    Route::get(
        '/invoice-details/{store_id}/{date}', [AdminProductController::class,'invoiceBundleDetails']);
    
    Route::post('/update-invoice-product', [AdminProductController::class,'updateInvoiceProduct']);


    //cheese bulk upload
    Route::get('products/cheese-bulk-upload', [AdminProductController::class, 'CheesebulkUploadForm'])
    ->name('products.cheese-bulk-upload');
    Route::get('/products/cheesedownload', [AdminProductController::class, 'CheesedownloadCSV'])->name('products.Cheesedownload');
    Route::post('/products/cheesebulkupload', [AdminProductController::class, 'CheeseuploadCSV'])->name('products.cheesebulkupload');

    // Products management
    Route::resource('products', AdminProductController::class);

    Route::post('products/toggle-featured/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'toggleFeatured'])
        ->name('products.toggle-featured');

    // Cheese Products management
    Route::resource('cheese-products', \App\Http\Controllers\Admin\CheeseProductController::class)
        ->parameters(['cheese-products' => 'cheese_product']);

    // API route to get cheese product details
    Route::get('api/cheese-products/{id}', [\App\Http\Controllers\Admin\CheeseProductController::class, 'getProductDetails']);

    // Testimonials management
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)
        ->middleware(['auth', 'admin'])
        ->parameters(['testimonials' => 'testimonial']);

    // Admin Review Management
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)
        ->middleware(['auth', 'admin'])
        ->parameters(['reviews' => 'review']);

    // Review status update route
    Route::post('reviews/{review}/status/{status}', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])
        ->middleware(['auth', 'admin'])
        ->name('admin.reviews.status');
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

    // Add cheese 
    Route::post('/stores/{store}/cheese/add',[StoreController::class, 'addCheese'])->name('stores.cheese.add');
    //edit cheese status
    Route::post('/stores/{store}/cheese/{cheese}/toggle',[StoreController::class, 'toggleCheese'])->name('stores.cheese.toggle');    

    // Add store wine
    Route::post('/stores/{store}/product/add',[StoreController::class, 'addProducts'])->name('stores.product.add');
    Route::post('/stores/{store}/product/{product}/toggle',[StoreController::class, 'toggleProduct'])->name('stores.product.toggle');


    //toggle features for a store
    Route::post('/stores/{store}/features/{feature}/toggle',[StoreController::class, 'toggleFeature'])->name('stores.feature.toggle');


    //template route
    Route::resource('templates', TemplateController::class);
    Route::post('/templates/{template}/product/add',[TemplateController::class, 'addProducts'])->name('templates.product.add');
    Route::delete('/templates/{template}/product/{product}',[TemplateController::class, 'removeProduct'])->name('templates.product.remove');
    Route::post('/templates/{template}/cheese/add',[TemplateController::class, 'addCheeseProducts'])->name('templates.cheese.add');
    Route::delete('/templates/{template}/cheese/{cheese}',[TemplateController::class, 'removeCheeseProduct'])->name('templates.cheese.remove');

    //Features
    Route::resource('features', FeatureController::class);

    //Analytics data
    Route::get('/analytics/store/{storeManagerId}/top-wines',[StoreAnalyticsController::class, 'topSellingWines']);

    //dowload analyitcs reports 
    Route::get('/stores/{store}/analytics/export',[StoreController::class, 'exportAnalytics'])->name('stores.analytics.export');


    //API key routes
    Route::post('/admin/stores/{store}/generate-api-key',[StoreController::class, 'generateApiKey'])->name('stores.generateApiKey');
    


    //Donwload documentation route
    Route::get('/admin/api/documentation',[UploadApiController::class, 'downloadApiDocumentation'])->name('api.documentation');


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
    Route::get('questionnaire-Images', [App\Http\Controllers\Admin\DashboardController::class, 'questionnaireimages'])->name('questionnaires.images');
    Route::post('questionnaire-StoreImages', [App\Http\Controllers\Admin\DashboardController::class, 'storeImages'])->name('questionnaires.storeImages');
    Route::delete('questionnaire-DeleteImage/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'deleteImage'])->name('questionnaires.deleteImage');
    Route::post('questionnaire-ToggleImage/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'toggleImage'])->name('questionnaires.toggleImage');
    

});

// User Questionnaire Routes
Route::middleware(['auth'])->group(function () {
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
    Route::get('/checkouts', [StoreDashboardController::class, 'checkouts'])->name('checkouts');
    Route::get('/uploads', [StoreDashboardController::class, 'uploads'])->name('uploads');
    Route::get('/download-sample',[StoreDashboardController::class,'StoreManagerdownloadSample'])->name('uploads.download');
    Route::post('/upload-csv',[StoreDashboardController::class,'StoreManageruploadCSV'])->name('uploads.upload');
    Route::post('/manual-entry',[StoreDashboardController::class,'StoreManagerManualEntry'])->name('uploads.store');
    Route::post('/uploads/update/{id}', [StoreDashboardController::class, 'update']);



    Route::get('/products', [StoreManagerProductController::class, 'index'])->name('products');
    Route::get('/products/{id}', [StoreManagerProductController::class, 'singleproduct'])->name('singleproduct');
    Route::get('/test', [StoreDashboardController::class, 'test'])->name('test');
    Route::post('/products/update-status', [StoreManagerProductController::class, 'updateStatus']);
    Route::post('/products/update-featured', [StoreManagerProductController::class, 'updateFeatured']);

    // Cheese Products Routes
    Route::get('/store-cheese-products', [\App\Http\Controllers\StoreManager\StoreManagerCheeseProductController::class, 'index'])->name('cheese-products.index');
    Route::post('/store-cheese-products/update-status', [\App\Http\Controllers\StoreManager\StoreManagerCheeseProductController::class, 'updateStatus'])->name('cheese-products.update-status');
    Route::post('/store-cheese-products/update-featured', [\App\Http\Controllers\StoreManager\StoreManagerCheeseProductController::class, 'updateFeatured'])->name('cheese-products.update-featured');

    //view all responses
    Route::get('/questionnaire/responses', [StoreDashboardController::class, 'showRespnses'])->name('questionnaire.responses');

    // View individual submission details
    Route::get('/questionnaire/responses/{submission_id}', [StoreDashboardController::class, 'showIndividualResponses'])->name('questionnaire.responses.show');

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

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('user.cart.updateQuantity');

// User Review Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/reviews', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('user.reviews.store');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\User\ReviewController::class, 'destroy'])->name('user.reviews.destroy');
});

// Show user profile
Route::get('/user/profile', [UserProfileController::class, 'show'])->name('user.userprofile.show');

// Show Store profile
Route::get('/profile', [StoreProfileController::class, 'show'])->name('user.storeprofile.show');
Route::get('/store-tab-profile', [StoreProfileController::class, 'storeTab'])->name('user.store-tab-profile.show');

// Update Contact Number (Form Submission)
Route::post('/store/update-contact', [StoreProfileController::class, 'updateContactNumber'])
    ->name('store.update.contact')
    ->middleware('auth');

// Main Manager - Approve Contact Number
Route::post('/manager/store/approve-contact/{storeId}', [MainManagerController::class, 'approveContactNumber'])
    ->name('manager.approve.contact')
    ->middleware('auth');

//get notification on header
Route::middleware(['auth'])->group(function () {
    Route::get('/manager/all-stores', [MainManagerController::class, 'MainManagerAllStores'])
        ->name('main-manager.all-stores');
});

// Update Password
Route::post('/profile/update-password', [UserProfileController::class, 'updatePassword'])
    ->name('profile.update.password');

Route::put('admin/reviews/{review}/update-status', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])
    ->name('admin.reviews.update-status');

require __DIR__ . '/auth.php';
