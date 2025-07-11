<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserSuggestionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SuggestionController as AdminSuggestionController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AccessCodeController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == HALAMAN UNTUK PENGGUNA UMUM ==
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/verifikasi', [UserSuggestionController::class, 'verifyAccessCode'])->name('suggestions.verifyAccessCode');
Route::get('/suggestions/create', [UserSuggestionController::class, 'create'])->name('suggestions.create');
Route::post('/suggestions', [UserSuggestionController::class, 'store'])->name('suggestions.store');


// == HALAMAN UNTUK ADMIN ==
Route::prefix('admin')->name('admin.')->group(function () {

    // --- Route untuk Autentikasi Admin ---
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // --- Grup Route yang dilindungi Middleware Admin ---
    Route::middleware([AdminMiddleware::class])->group(function () {

        // Route untuk mengelola Suggestions
        Route::get('/suggestions', [AdminSuggestionController::class, 'index'])->name('suggestions.index');
        Route::get('/suggestions/export/excel', [AdminSuggestionController::class, 'exportExcel'])->name('suggestions.export.excel');
        Route::get('/suggestions/{suggestion}', [AdminSuggestionController::class, 'show'])->name('suggestions.show');
        Route::put('/suggestions/{suggestion}', [AdminSuggestionController::class, 'update'])->name('suggestions.update');
        Route::delete('/suggestions/{suggestion}', [AdminSuggestionController::class, 'destroy'])->name('suggestions.destroy');
        Route::post('/suggestions/bulk-destroy', [AdminSuggestionController::class, 'bulkDestroy'])->name('suggestions.bulkDestroy');

        // Route untuk mengelola Departments
        Route::resource('/departments', DepartmentController::class);

        // [DIUBAH] Route untuk Kode Akses menggunakan sintaks yang Anda berikan
        Route::resource('access-codes', AccessCodeController::class)->names([
            'index' => 'access_codes.index',
            'create' => 'access_codes.create',
            'store' => 'access_codes.store',
            'show' => 'access_codes.show',
            'edit' => 'access_codes.edit',
            'update' => 'access_codes.update',
            'destroy' => 'access_codes.destroy',
        ]);
    });
});


// == ROUTE REDIRECT BAWAAN LARAVEL ==
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        // Arahkan ke halaman daftar suggestion
        return redirect()->route('admin.suggestions.index');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');