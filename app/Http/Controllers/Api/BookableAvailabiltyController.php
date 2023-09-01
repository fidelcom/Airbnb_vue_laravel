<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableAvailabiltyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Bookable $bookable, Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);
//        dd($bookable->bookings()->betweenDates($data['from'], $data['to'])->count());
//        dd($bookable->availableFor($data['from'], $data['to']));
        return $bookable->availableFor($data['from'], $data['to']) ? response()->json([]) : response()->json([], 404);
    }
}
