<?php
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ruta de prueba (como la que ya agregaste)
Route::get('/test-api', [ReportController::class, 'testApi']);

Route::get('/orders', [OrdersController::class, 'index']);
Route::post('/orders', [OrdersController::class, 'store']);
Route::get('/orders/{id}', [OrdersController::class, 'show']);
Route::put('/orders/{id}', [OrdersController::class, 'update']);
Route::delete('/orders/{id}', [OrdersController::class, 'destroy']);


Route::get('/ejercicio1', [ReportController::class, 'totalOrdersFirstClass']);
Route::get('/ejercicio2/{customerId}', [ReportController::class, 'totalOrdersByCustomer']);
Route::get('/ejercicio3', [ReportController::class, 'mostProfitableProductByCategory']);
Route::get('/ejercicio4', [ReportController::class, 'topCustomersLastYear']);
Route::get('/ejercicio5', [ReportController::class, 'avgSalesAndProfitBySegment']);
Route::get('/ejercicio6', [ReportController::class, 'topSellingProductsBySubCategory']);
Route::get('/ejercicio7', [ReportController::class, 'salesAndProfitTrendsByCategory']);
Route::get('/ejercicio8', [ReportController::class, 'shippingModeProfitability']);
Route::get('/ejercicio9', [ReportController::class, 'customersPurchasedAllCategories']);
Route::get('/ejercicio10', [ReportController::class, 'salesAndProfitByRegionAndSegment']);
Route::get('/ejercicio11', [ReportController::class, 'customersWithMoreThan10OrdersPerYear']);
