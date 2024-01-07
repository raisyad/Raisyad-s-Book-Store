<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksCategoryController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ViewAccountController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/login', function () {
//     return view('pages/user/Login');
// });

// Route::get('/regist', function () {
//     return view('pages/user/Register');
// });

// LOGIN & LOGOUT SYSTEM
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticating'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// AUTHENTICATING USER
Route::get('/reg', [AuthController::class, 'register'])->middleware('guest');
Route::post('/create-account-user', [AuthController::class, 'creatingacc'])->middleware('guest');

// AUTHENTICATING ADMIN
Route::get('/reg-admin', [AuthController::class, 'registerAdmin'])->middleware(['auth', 'admin']);
Route::post('/create-account-admin', [AuthController::class, 'creatingaccAdmin'])->middleware(['auth', 'admin']);


Route::get('/', [UsersController::class, 'index'])->middleware('auth');
// ['auth', 'admin']
Route::get('/bookscat', [BooksCategoryController::class, 'index'])->middleware('auth');
Route::get('/bookscat-add', [BooksCategoryController::class, 'create'])->middleware(['auth', 'admin']);
Route::post('/bookscat-created', [BooksCategoryController::class, 'store'])->middleware(['auth', 'admin']);
Route::get('/bookscat-edit/{id}', [BooksCategoryController::class, 'edit'])->middleware(['auth', 'admin']);
Route::put('/bookscat-updated/{id}', [BooksCategoryController::class, 'update'])->middleware(['auth', 'admin']);
Route::delete('/bookscat-deleted/{id}', [BooksCategoryController::class, 'destroy'])->middleware(['auth', 'admin']);

// Books
Route::get('/books', [BooksController::class, 'index'])->middleware('auth');
Route::get('/books/{id}/detail-view', [BooksController::class, 'show'])->middleware('auth');
Route::get('/books-detail-download/{id}', [BooksController::class, 'export_pdf'])->middleware('auth');
// Route::get('/books-detail-download/{id}', [BooksController::class, 'show_pdf'])->middleware('auth');
Route::get('/books-add', [BooksController::class, 'create'])->middleware('auth');
Route::post('/books-created', [BooksController::class, 'store'])->middleware('auth');
Route::get('/books-edit/{id}', [BooksController::class, 'edit'])->middleware('auth');
Route::put('/books-updated/{id}', [BooksController::class, 'update'])->middleware('auth');
Route::delete('/books-deleted/{id}', [BooksController::class, 'destroy'])->middleware('auth');

Route::get('/view-all-account', [ViewAccountController::class, 'index'])->middleware(['auth', 'admin']);
