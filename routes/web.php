<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| 1. Authentication Routes (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 2. Protected Routes (Require Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // =========================================================
    // LEVEL 1: EVERYONE (User, Staff, Admin)
    // Permission: POS Access Only
    // =========================================================
    Route::middleware(['role:admin,staff,user'])->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos/add/{id}', [PosController::class, 'addToCart'])->name('pos.store');
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('/pos/update/{id}/{action}', [PosController::class, 'updateCart'])->name('pos.update');
    });

    // =========================================================
    // LEVEL 2: STAFF & ADMIN
    // Permission: Products (View), Categories, Members, Adjustments
    // =========================================================
    Route::middleware(['role:admin,staff'])->group(function () {

        // --- Products (View Only) ---
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');

        // --- Categories (Full Access) ---
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // --- Customers / Members (Full Access) ---
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        // --- Stock Adjustments (Add Only) ---
        Route::get('/stock', [StockTransactionController::class, 'index'])->name('stock.index');
        Route::get('/stock/create', [StockTransactionController::class, 'create'])->name('stock.create');
        Route::post('/stock', [StockTransactionController::class, 'store'])->name('stock.store');
    });

    // =========================================================
    // LEVEL 3: ADMIN ONLY
    // Permission: Full Control (Dashboard, Reports, Employees, Settings)
    // =========================================================
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- Product Management (Create, Edit, Delete) ---
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // --- Stock Management (Edit, Delete Logs) ---
        Route::get('/stock/{id}/edit', [StockTransactionController::class, 'edit'])->name('stock.edit');
        Route::put('/stock/{id}', [StockTransactionController::class, 'update'])->name('stock.update');
        Route::delete('/stock/{id}', [StockTransactionController::class, 'destroy'])->name('stock.destroy');

        // --- Employees ---
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

        // --- Suppliers ---
        Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

        // --- Positions ---
        Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
        Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
        Route::get('/positions/{position}/edit', [PositionController::class, 'edit'])->name('positions.edit');
        Route::put('/positions/{position}', [PositionController::class, 'update'])->name('positions.update');
        Route::delete('/positions/{position}', [PositionController::class, 'destroy'])->name('positions.destroy');

        // --- User Management ---
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // --- Reports ---
        Route::get('/reports/sale', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/invoice/{id}', [ReportController::class, 'invoice'])->name('reports.invoice');
        Route::delete('/reports/sales/{id}', [ReportController::class, 'destroy'])->name('sales.destroy');
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
        Route::get('/reports/sales/print', [ReportController::class, 'printSales'])->name('reports.sales.print');
    });
});