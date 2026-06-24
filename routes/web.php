<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderWizardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\XenditWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/template', [TemplateController::class, 'index'])->name('templates.index');
Route::get('/template/{slug}', [TemplateController::class, 'show'])->name('templates.show');

Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/paket', [PricingController::class, 'index'])->name('pricing.index');

Route::get('/portofolio', [PortfolioController::class, 'index'])->name('portfolio.index');

Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/tentang', [AboutController::class, 'index'])->name('about.index');

Route::get('/komunitas', [CommunityController::class, 'index'])->name('community.index');

// ---- Chat Us — asisten AI Conweb ----
Route::post('/chat-us', [ChatController::class, 'send'])->middleware('throttle:20,1')->name('chat.send');

// ---- Auth (login / register / verifikasi OTP / Google) ----
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register']);
    Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/verifikasi', [AuthController::class, 'showVerify'])->name('verify.show');
    Route::post('/verifikasi', [AuthController::class, 'verify'])->name('verify.submit');
    Route::post('/verifikasi/kirim-ulang', [AuthController::class, 'resend'])->name('verify.resend');
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');
});

// ---- Akun pelanggan & tracking pengerjaan ----
Route::middleware(['auth', 'verified.otp'])->group(function () {
    Route::get('/akun', [AccountController::class, 'index'])->name('account.index');
    Route::get('/akun/pesanan/{code}', [AccountController::class, 'order'])->name('account.order');
});

Route::get('/pesan', [OrderController::class, 'create'])->name('order.create');
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');

// Pemesanan wajib login & email terverifikasi.
Route::prefix('order')->name('order-wizard.')->middleware(['auth', 'verified.otp'])->group(function () {
    Route::get('/start', [OrderWizardController::class, 'start'])->name('start');
    Route::get('/domain', [OrderWizardController::class, 'domain'])->name('domain');
    Route::get('/domain/check', [OrderWizardController::class, 'checkDomain'])->name('domain.check');
    Route::post('/domain', [OrderWizardController::class, 'storeDomain'])->name('domain.store');
    Route::get('/template', [OrderWizardController::class, 'template'])->name('template');
    Route::post('/template', [OrderWizardController::class, 'storeTemplate'])->name('template.store');
    Route::get('/profile', [OrderWizardController::class, 'profile'])->name('profile');
    Route::post('/profile', [OrderWizardController::class, 'storeProfile'])->name('profile.store');
    Route::get('/checkout', [OrderWizardController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/recalculate', [OrderWizardController::class, 'recalculate'])->name('checkout.recalculate');
    Route::post('/checkout/promo', [OrderWizardController::class, 'applyPromo'])->name('checkout.promo');
    Route::post('/checkout', [OrderWizardController::class, 'storeCheckout'])->name('checkout.store');
});
Route::get('/order/thanks', [OrderWizardController::class, 'thanks'])->middleware(['auth', 'verified.otp'])->name('order.thanks');

Route::post('/webhooks/xendit', [XenditWebhookController::class, 'handle'])->name('webhooks.xendit');
