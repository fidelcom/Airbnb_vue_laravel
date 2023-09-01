<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function show(Review $review)
    {
//        $review = Review::find($id);
//        if ($review) {
//            return new ReviewResource($review);
//        } else {
////            return response()->json(['error' => 'Review not found'], abort(404));
//            return response()->json(['error' => 'Review not found'], Response::HTTP_NOT_FOUND);
//        }

        return new ReviewResource($review);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|size:36|unique:reviews',
            'content' => 'required|min:2',
            'rating' => 'required|in:1,2,3,4,5'
        ]);
//        dd($data);

        $booking = Booking::findByReviewKey($data['id']);

        if (null == $booking)
        {
            return abort(404);
        }

        $booking->review_key = '';
        $booking->save();
//        dd($booking->id);

//        $review = new Review();
        $review = Review::create([
            'id' => $data['id'],
            'content' => $data['content'],
            "rating" => $data['rating'],
            'bookable_id' => $booking->bookable_id,
            'booking_id' => $booking->id,
        ]);

//        $review->id = $data['id'];
//        $review->content = $data['content'];
//        $review->rating = $data['rating'];
////        $review->booking_id = $booking->id;
////        $review->bookable_id = $booking->bookable_id;
//        $review->booking_id = $booking->id;
//        $review->bookable_id = $booking->bookable_id;
//        $review->save();

        return new ReviewResource($review);
    }
}
