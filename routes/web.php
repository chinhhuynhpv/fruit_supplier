<?php

use App\Helper\RouteGenerator;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\StaffAuthController;
use App\Http\Controllers\Staff\StaffTopController;
use App\Http\Controllers\Management\FruitCategoryController;
use App\Http\Controllers\Management\FruitController;
use App\Http\Controllers\Management\InvoiceController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::domain(env('STAFF_SUB_DOMAIN') . '.' . env('APP_URL'))->group(function () {

    Route::get('/login', [StaffAuthController::class, 'login'])->name('staff.login');
    Route::post('/login', [StaffAuthController::class, 'handleLogin'])->name('staff.handleLogin');

    // top
    Route::get('/top', [StaffTopController::class, 'index'])->name('staff.top')->middleware('auth:staff');

    //Logout
    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

    
    //staff Management
    Route::group(['middleware' => ['auth:staff']], function () {

        //fruit category Management
        Route::group(['prefix' => 'fruit-category'], function () {
            Route::get('/list', [FruitCategoryController::class, 'index'])->name('fruitCategoryList');
            Route::get('/create', [FruitCategoryController::class, 'create'])->name('fruitCategoryCreate');
            Route::post('/create', [FruitCategoryController::class, 'store'])->name('fruitCategoryStore');
            Route::get('/edit/{id}', [FruitCategoryController::class, 'edit'])->name('fruitCategoryEdit');
            Route::post('/update/{id}', [FruitCategoryController::class, 'update'])->name('fruitCategoryUpdate');
            Route::delete('/delete', [FruitCategoryController::class, 'delete'])->name('fruitCategoryDelete');
        });


        //fruit Management
        Route::group(['prefix' => 'fruit'], function () {
            Route::get('/list', [FruitController::class, 'index'])->name('fruitList');
            Route::get('/create', [FruitController::class, 'create'])->name('fruitCreate');
            Route::post('/create', [FruitController::class, 'store'])->name('fruitStore');
            Route::get('/edit/{id}', [FruitController::class, 'edit'])->name('fruitEdit');
            Route::post('/update/{id}', [FruitController::class, 'update'])->name('fruitUpdate');
            Route::delete('/delete', [FruitController::class, 'delete'])->name('fruitDelete');
        });

        //invoice Management
        Route::group(['prefix' => 'invoice'], function () {
            Route::get('/list', [InvoiceController::class, 'index'])->name('invoiceList');
            Route::get('/create', [InvoiceController::class, 'create'])->name('invoiceCreate');
            Route::get('/detail/{id}', [InvoiceController::class, 'detail'])->name('invoiceDetail');
            Route::post('/create', [InvoiceController::class, 'store'])->name('invoiceStore');
            Route::delete('/delete', [InvoiceController::class, 'delete'])->name('invoiceDelete');
            Route::get('/export/{id}', [InvoiceController::class, 'export'])->name('invoiceExport');
             // Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('invoiceEdit');
            // Route::post('/update/{id}', [InvoiceController::class, 'update'])->name('invoiceUpdate');
        });
    });
});