<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSuggestionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SuggestionController as AdminSuggestionController;
use App\Http\Controllers\Admin\DepartmentController; // [BARU] Import DepartmentController
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\HomeController;

// Route untuk halaman utama, sekarang menampilkan landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk menampilkan form pengajuan suggestion
Route::get('/suggestions/create', [UserSuggestionController::class, 'create'])->name('suggestions.create');

// Route untuk menyimpan data suggestion yang diajukan
Route::post('/suggestions', [UserSuggestionController::class, 'store'])->name('suggestions.store');

// ------ Route Autentikasi Admin ------
Route::prefix('admin')->name('admin.')->group(function () {
    // Route untuk login, register, logout admin (tidak dilindungi middleware admin)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // HATI-HATI: Route register sebaiknya dihapus di production atau diberi middleware khusus
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Logout harus bisa diakses oleh user yang sudah login
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Grup Route untuk Area Admin yang Terlindungi
    // Menggunakan class middleware langsung karena belum terdaftar alias
    Route::middleware([AdminMiddleware::class])->group(function () {
        
        // Route untuk mengelola Suggestions oleh Admin
        Route::get('/suggestions', [AdminSuggestionController::class, 'index'])->name('suggestions.index');
        Route::get('/suggestions/export/excel', [AdminSuggestionController::class, 'exportExcel'])->name('suggestions.export.excel');
        Route::get('/suggestions/{suggestion}', [AdminSuggestionController::class, 'show'])->name('suggestions.show');
        Route::put('/suggestions/{suggestion}', [AdminSuggestionController::class, 'update'])->name('suggestions.update');
        Route::delete('/suggestions/{suggestion}', [AdminSuggestionController::class, 'destroy'])->name('suggestions.destroy');
        Route::post('/suggestions/bulk-destroy', [AdminSuggestionController::class, 'bulkDestroy'])->name('suggestions.bulkDestroy');

        // [BARU] Route untuk mengelola Departments oleh Admin
        // Route::resource akan otomatis membuat semua route yang diperlukan (index, create, store, edit, update, destroy)
        Route::resource('/departments', DepartmentController::class);
    });
});

// Route /dashboard bawaan Laravel untuk redirect
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');