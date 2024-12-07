<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PengajuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\checkRole;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


// Route::get('/', [BlogController::class, 'index']);
// Route::get('/blog/detail/{data}', [BlogController::class, 'show'])->name('detail');

// Route::controller(BookController::class)->group(function () {
//     Route::get('/books', 'index')->name('books.index');
//     Route::get('/books/create', 'create')->name('books.create');
//     Route::post('/books', 'store')->name('books.store');
//     Route::get('/books/{id}', 'show')->name('books.show');
//     Route::get('/books/{id}/edit', 'edit')->name('books.edit');
//     Route::put('/books/{id}', 'update')->name('books.update');
//     Route::delete('/books/{id}', 'destroy')->name('books.destroy');
// });

// Route::get('greeting', [GreetingController::class, 'index'])->name('greeting');
// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/about', [AboutController::class, 'index'])->name('about');

// Route::resource('blogs', BlogController::class);

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::prefix('en')->group(function () {
    Route::get('posts', [HomeController::class, 'posts'])->name('posts.index');
    Route::get('posts/{code_post}', [HomeController::class, 'postShow'])->name('posts.show');

    Route::middleware('auth')->group(function () {
        Route::post('posts/{code_post}/comments', [HomeController::class, 'postComment'])->name('comments.store');

        Route::middleware(checkRole::class)->group(function () {
            Route::prefix('admin')->name('admin.')->group(function () {
                Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
                Route::resource('posts', PostController::class);
                Route::middleware(IsAdmin::class)->group(function () {
                    Route::resource('categories', CategoryController::class);
                    Route::resource('users', UserController::class);
                });
            });
        });

        Route::get('search', [HomeController::class, 'search'])->name('search');
        Route::get('like/{code_post}', [HomeController::class, 'like'])->name('like');
        Route::get('dislike/{code_post}', [HomeController::class, 'dislike'])->name('dislike');

        Route::post('/comments/{id}/approve', [HomeController::class, 'approve'])->name('comments.approve');
        Route::post('/comments/{id}/reject', [HomeController::class, 'reject'])->name('comments.reject');
    });

    Route::get('pengajuan-author', [PengajuanController::class, 'index']);
    Route::post('pengajuan-author', [PengajuanController::class, 'PengajuanAuthor'])->name('pengajuan-author');

    Auth::routes();
});

Route::fallback(function () {
    return redirect()->back();
});
