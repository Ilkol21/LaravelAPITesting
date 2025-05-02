<?php


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::post('user/login', 'auth');
    Route::post('user/register', 'store');
});

// Public
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}/comments', [CommentController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('comments', [CommentController::class, 'index']);


// 🔐 Only authorize
Route::middleware('auth:sanctum')->group(function () {
    // Current user
    Route::get('user', fn(Request $request) => UserResource::make($request->user()));

    Route::controller(UserController::class)->group(function () {
        Route::post('user/logout', 'logout');
    });

    Route::apiResource('products', ProductController::class)->except(['index']);

    // Comment
    Route::post('products/{product}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);

    // History
    Route::get('purchase-history', [PurchaseHistoryController::class, 'index']);

    // Category
    Route::apiResource('categories', CategoryController::class)->except(['index']);

    Route::post('/purchase', [PurchaseController::class, 'store']);
});

Route::get('/test', fn() => 'Test route works!');
Route::get('/', fn() => 123);
