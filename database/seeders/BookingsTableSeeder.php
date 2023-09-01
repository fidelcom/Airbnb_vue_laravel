<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bookable::all()->each(function (Bookable $bookable){
            $booking = factory(Booking::class)->make();
            $bookings = collect([$booking]);

            for($i = 0; $i < random_int(1, 20); $i++){
                $from = (clone $booking->to)->addDays(random_int(1, 29));
                $to = (clone $from)->addDays(random_int(0, 30));

                $booking = Booking::make([
                    'from' => $from,
                    'to' => $to
                ]);

                $bookings->push($booking);
            }

            $bookable->bookings()->saveMany($bookings);
        });
    }
}
