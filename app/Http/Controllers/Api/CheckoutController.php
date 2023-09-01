<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Bookable;
use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public $bookable;
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',
            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.street' => 'required|min:2',
            'customer.city' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.country' => 'required|min:2',
            'customer.zip' => 'required|min:2',
        ]);



        $data = array_merge($data, (array)Validator::make($request->all(),[
            'bookings.*' => ['required', function (string $attribute, mixed $value, Closure $fail) {
//                $this->bookable = Bookable::findOrFail($value['bookable_id']);
                $this->bookable = Bookable::findOrFail($value['bookable_id']);
                if (!$this->bookable->availableFOr($value['from'], $value['to'])) {
                    $fail("The {$attribute} is not available for the given dates.");
                }
            }],
        ]));

        $bookingData = $data['bookings'];
        $addressData = $data['customer'];


        $bookings = collect($bookingData)->map(function ($bookingData) use($addressData) {
            $bookable = Bookable::findOrfail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
//            dd(Bookable::find($bookingData['bookable_id'])->priceFor($booking->from, $booking->to)['total']);
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
//            $booking->bookable_id = $bookingData['bookable_id'];
            $booking->bookable()->associate($bookable);

            $booking->address()->associate(Address::create($addressData));
            $booking->save();

            return $booking;
        });

        return $bookings;
    }
}
