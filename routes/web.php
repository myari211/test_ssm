<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('role:admin')->prefix('admin')->group(function() {
        Route::get('dashboard/{id}', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::prefix('book')->group(function() {
            //category
            Route::get('category', [App\Http\Controllers\Admin\BookController::class, 'book_category'])->name('admin.books_category');
            Route::post('category/create', [App\Http\Controllers\Admin\BookController::class, 'create_category'])->name('admin.create_category');

            //book
            Route::get('list', [App\Http\Controllers\Admin\BookController::class, 'list'])->name('admin.books_list');
            Route::post('list/create', [App\Http\Controllers\Admin\BookController::class, 'create_book'])->name('admin.create_book');
        });

        Route::prefix('user')->group(function() {
            Route::get('list', [App\Http\Controllers\Admin\UserController::class, 'list'])->name('admin.users');
            Route::post('create', [App\Http\Controllers\Admin\UserController::class, 'create_user'])->name('admin.create_user');
        });

        Route::prefix('transaction')->group(function() {
            Route::get('list', [App\Http\Controllers\Admin\TransactionController::class, 'list'])->name('admin.transaction');
            Route::post('create', [App\Http\Controllers\Admin\TransactionController::class, 'create'])->name('admin.create_transaction');
            Route::post('update/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'update'])->name('admin.update_transaction');
        });
});

// Route::middleware('role:admin')->group(['prefix' => 'admin'], function() {
    // Route::get('/dashboard/{id}', [App\Http\Controllers\Admin\DashboardController])
// });
