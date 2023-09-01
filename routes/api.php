<?php

use App\Http\Controllers\Api\BookableAvailabiltyController;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\BookablePriceController;
use App\Http\Controllers\Api\BookableReviewController;
use App\Http\Controllers\Api\BookingByReviewController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('bookables', function (Request $request){
//    return \App\Models\Bookable::all();
//});
//
//Route::get('bookables/{id}', function (Request $request, $id){
//    return \App\Models\Bookable::find($id);
//});

Route::apiResource('bookables', BookableController::class);
Route::get('bookables/{bookable}/availability', BookableAvailabiltyController::class)
    ->name('bookables.availability.show');
Route::get('bookables/{bookable}/reviews', BookableReviewController::class)
    ->name('bookables.reviews.index');
Route::get('bookables/{bookable}/price', BookablePriceController::class)
    ->name('bookables.price.show');

Route::get('/booking-by-review/{reviewKey}', BookingByReviewController::class )
    ->name('booking.by-review.show');

Route::apiResource('reviews', ReviewController::class)->only(['show', 'store']);

Route::post('checkout', CheckoutController::class)->name('checkout');
