<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Admin\{DashboardController as AdminDash, UserController as AdminUser, CompanyController as AdminCompany, ProductController as AdminProduct, ReportController};
use App\Http\Controllers\Business\{DashboardController as BizDash, CompanyController as BizCompany, ProductController as BizProduct, ExpenseController};
use App\Http\Controllers\User\{DashboardController as UserDash, ProfileController, CartController, OrderController};


// Página pública
Route::get('/', [HomeController::class, 'index'])->name('home');

// Páginas públicas de empresa (sin login)
Route::get('/empresas/{company}',         [PublicController::class, 'company'])->name('public.company');
Route::get('/empresas/{company}/tooltip', [PublicController::class, 'companyTooltip'])->name('public.company.tooltip');


// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Google OAuth
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Verificación de Email (Google nuevos usuarios)
Route::get('/verify-email',           [EmailVerificationController::class, 'showNotice'])->name('verify.notice');
Route::get('/verify-email/codigo',    [EmailVerificationController::class, 'showForm'])->name('verify.form');
Route::post('/verify-email/codigo',   [EmailVerificationController::class, 'verify'])->name('verify.submit');
Route::post('/verify-email/reenviar', [EmailVerificationController::class, 'resend'])->name('verify.resend');

// Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDash::class, 'index'])->name('dashboard');

    Route::resource('users', AdminUser::class);
    Route::patch('users/{user}/toggle', [AdminUser::class, 'toggleActive'])->name('users.toggle');

    Route::get('companies', [AdminCompany::class, 'index'])->name('companies.index');
    Route::patch('companies/{company}/toggle', [AdminCompany::class, 'toggleStatus'])->name('companies.toggle');
    Route::patch('companies/{company}/document-update-status', [AdminCompany::class, 'documentUpdateStatus'])->name('companies.document_update_status');
    Route::delete('companies/{company}', [AdminCompany::class, 'destroy'])->name('companies.destroy');

    Route::get('products', [AdminProduct::class, 'index'])->name('products.index');
    Route::patch('products/{product}/toggle', [AdminProduct::class, 'toggleActive'])->name('products.toggle');
    Route::delete('products/{product}', [AdminProduct::class, 'destroy'])->name('products.destroy');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});

// Empresario
Route::prefix('business')->name('business.')->middleware(['auth', 'role:business'])->group(function () {
    Route::get('/dashboard', [BizDash::class, 'index'])->name('dashboard');

    Route::get('company/edit',   [BizCompany::class, 'edit'])->name('company.edit');
    Route::post('company/update', [BizCompany::class, 'update'])->name('company.update');
    Route::post('company/request-document-update', [BizCompany::class, 'requestDocumentUpdate'])->name('company.request_document_update');

    Route::resource('products', BizProduct::class);

    Route::get('expenses',         [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('expenses/create',  [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('expenses',        [ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});

// Usuario
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDash::class, 'index'])->name('dashboard');
    Route::get('/map',       [UserDash::class, 'map'])->name('map');

    Route::get('profile/edit',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('cart',                     [CartController::class, 'index'])->name('cart.index');
    Route::get('cart/checkout',            [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/checkout/process',    [CartController::class, 'processPayment'])->name('cart.payment.process');
    
    Route::post('cart/{product}',          [CartController::class, 'add'])->name('cart.add');
    Route::delete('cart/{product}',        [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('cart/{product}',         [CartController::class, 'update'])->name('cart.update');


    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
});

// Chat Global
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/api/unread-count', [ChatController::class, 'unreadCount'])->name('chat.unread.count');
    Route::get('/chat/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{receiver}', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/api/{receiver}', [ChatController::class, 'getMessages'])->name('chat.messages');
});

// AI Chatbot Widget (available to all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot/message',     [ChatbotController::class, 'message'])->name('chatbot.message');
    Route::post('/chatbot/detect-lang', [ChatbotController::class, 'detectLang'])->name('chatbot.detect-lang');
});
