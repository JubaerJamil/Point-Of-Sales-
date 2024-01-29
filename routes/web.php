<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SummaryController;
use App\Http\Middleware\TokenVerificationMiddleware;

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

// Auth API Route

Route::post('/user-registration', [UserController::class, 'userregistration']);
Route::post('/user-login', [UserController::class, 'userlogin']);
Route::post('/send-otp-code', [UserController::class, 'sendotpcode']);
Route::post('/Otp-verify', [UserController::class, 'Otpverify']);
Route::post('/Set-Password', [UserController::class, 'SetPassword'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/user-profile', [UserController::class, 'userprofile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/profile-update', [UserController::class, 'profileupdate'])->middleware([TokenVerificationMiddleware::class]);


//logout
Route::get('/logout', [UserController::class, 'userlogout']);


// Auth Page Route

Route::get('/User-Registration', [UserController::class, 'RegistrationPage']);
Route::get('/', [UserController::class, 'LoginPage']);
Route::get('/send-otp', [UserController::class, 'EmailOTPpage']);
Route::get('/Verify-OTP', [UserController::class, 'VerifyOTPpage']);
Route::get('/Reset-Password', [UserController::class, 'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/user/user-profile', [UserController::class, 'ProfilePage']);

// Route::get('/user-name', [UserController::class, 'profile'])->name('layout.app')->middleware([TokenVerificationMiddleware::class]);

// category API

Route::get('/category-list', [CategoryController::class, 'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-category', [CategoryController::class, 'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-update', [CategoryController::class, 'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-delete', [CategoryController::class, 'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-By-Id', [CategoryController::class, 'CategoryUpdateById'])->middleware([TokenVerificationMiddleware::class]);

// Category page route

Route::get('/category-page', [CategoryController::class, 'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);


// Customer API

Route::get('/customer-list', [CustomerController::class, 'customerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-customer', [CustomerController::class, 'customerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-customer', [CustomerController::class, 'customerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-update', [CustomerController::class, 'customerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-by-id', [CustomerController::class, 'customerById'])->middleware([TokenVerificationMiddleware::class]);


// Customer page route

Route::get('/customer-page', [CustomerController::class, 'customerPage'])->middleware([TokenVerificationMiddleware::class]);


// product API

Route::post('create-product', [ProductController::class, 'productCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('product-by-id', [ProductController::class, 'productById'])->middleware([TokenVerificationMiddleware::class]);
Route::get('product-list', [ProductController::class, 'productList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('product-delete', [ProductController::class, 'productDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('product-update', [ProductController::class, 'productUpdate'])->middleware([TokenVerificationMiddleware::class]);

// Product page route

Route::get('product-page', [ProductController::class, 'productpage'])->middleware([TokenVerificationMiddleware::class]);


    // Incoice API

Route::post('invoice-create', [InvoiceController::class, 'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('invoice-select', [InvoiceController::class, 'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post('invoice-details', [InvoiceController::class, 'invoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post('invoice-delete', [InvoiceController::class, 'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);

// Incoice page route

Route::get('invoice-page', [InvoiceController::class, 'invoicepage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('invoice-list', [InvoiceController::class, 'invoiclist'])->middleware([TokenVerificationMiddleware::class]);


// Summary API route
Route::get('summary-report', [SummaryController::class, 'summary'])->middleware([TokenVerificationMiddleware::class]);

// Summary page route
Route::get('sales-summary', [SummaryController::class, 'summarypage'])->middleware([TokenVerificationMiddleware::class]);

// report page route
Route::get('report-download', [ReportController::class, 'reportpage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/sales-report/{FormDate}/{ToDate}', [ReportController::class, 'salesreport'])->middleware([TokenVerificationMiddleware::class]);

