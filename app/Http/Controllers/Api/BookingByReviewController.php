<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewShowResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Booking $booking, $reviewKey, Request $request)
    {
        $book = $booking->findByReviewKey($reviewKey);
        return $book ? new BookingByReviewShowResource( $book ) : abort(404);
    }
}
