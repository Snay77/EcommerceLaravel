<?php

use App\Http\Controllers\Cart\AddItemController;
use App\Http\Controllers\Cart\ShowCartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowAllCategoryController;
use App\Http\Controllers\ShowAllProductController;
use App\Http\Controllers\ShowCategoryController;
use App\Http\Controllers\ShowProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get("/", HomeController::class)->name("home");

Route::get('/categories', ShowAllCategoryController::class)->name('categories');
Route::get('/categories/{category}', ShowCategoryController::class)->name('categories.show');

Route::get('/products', ShowAllProductController::class)->name('products');
Route::get('/products/{product}', ShowProductController::class)->name('product.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/cart', ShowCartController::class)->name('cart.show');
    Route::post('/cart/products/{product}', AddItemController::class)->name('cart.add');
    // Route::put('/cart/items/{item}', UpdateItemController::class)->name('cart.update');
    // Route::delete('/cart/items/{item}', RemoveItemController::class)->name('cart.remove');

    // Route::get('/addresses', ListAddressController::class)->name('addresses.index');
    // Route::post('/addresses', CreateAddressController::class)->name('addresses.store');
    // Route::put('/addresses/{address}', UpdateAddressController::class)->name('addresses.update');
    // Route::delete('/addresses/{address}', DeleteAddressController::class)->name('addresses.delete');
    // Route::put('addresses/{address)/default', SetDefaultAddressController::class)->name('addresses.default');

    // Route::get('/orders', ListOrdersController::class)->name('orders.index');
    // Route::post('/orders', CreateOrderController::class)->name('orders.store');
    // Route::get('/orders/{order}', ShowOrderController::class)->name('orders.show');
});