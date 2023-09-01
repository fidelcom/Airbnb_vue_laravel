<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResourceler;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Bookable $bookable, Request $request)
    {
//        $bookable = Bookable::findOrFail($id);
//        dd($bookable->reviews()->latest()->get());
        return BookableReviewIndexResourceler::collection(
            $bookable->reviews()->latest()->get()
        );

    }
}
