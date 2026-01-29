<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Provider\ProviderDashboardController;
use App\Http\Controllers\Provider\ProviderPaymentController;
use App\Http\Controllers\Provider\ServiceController as ProviderServiceController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('services', ServiceController::class);
        Route::resource('bookings', BookingController::class);
        // Route::resource('payments', PaymentController::class);
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::resource('categories', CategoryController::class);
        Route::post('/admin/services/{service}/approve', [ServiceController::class, 'approve'])->name('services.approve');
        Route::delete('/users/{id}', [AdminDashboardController::class, 'destroy'])->name('users.destroy');
    });


Route::prefix('provider')
    ->name('provider.')
    ->middleware(['auth', 'role:provider'])
    ->group(function () {
        Route::get('/dashboard', [ProviderDashboardController::class, 'index'])->name('dashboard');
        Route::get('/payments', [ProviderPaymentController::class, 'index'])->name('payments.index');
        Route::resource('bookings', \App\Http\Controllers\Provider\BookingController::class);
        Route::resource('services', ProviderServiceController::class);
    });

Route::prefix('customer')
    ->name('customer.')
    ->middleware(['auth', 'role:customer'])
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('bookings', CustomerBookingController::class);
    });

Route::prefix('customer')
    ->middleware(['auth', 'role:customer'])
    ->name('payment.')
    ->group(function () {
        Route::get('/checkout/{service}', [PaymentController::class, 'checkout'])->name('checkout');
        Route::get('/success/{service}', [PaymentController::class, 'success'])->name('success');
        Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
    });


require __DIR__ . '/auth.php';
