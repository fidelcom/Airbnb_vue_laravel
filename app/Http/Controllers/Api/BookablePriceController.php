<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Bookable $bookable, Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

//        $days = (new Carbon($data['from']))->diffInDays(new Carbon($data['to'])) + 1;
//        $price = $days * $bookable->price;

//        return response()->json([
//            'data' => [
//                'total' => $price,
//                'breakdown' => [
//                    $bookable->price => $days
//                ]
//            ]
//        ]);
        return response()->json([
            'data' => $bookable->priceFor($data['from'], $data['to'])
        ]);
    }
}
