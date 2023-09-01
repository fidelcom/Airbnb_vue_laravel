<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bookable;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Bookable::factory(100)->create();
//        $this->call(BookingsTableSeeder::class);

        Bookable::all()->each(function (Bookable $bookable){
            $booking = Booking::factory()->make();
            $bookings = collect([$booking]);

            for($i = 0; $i < random_int(1, 20); $i++){
                $from = (clone $booking->to)->addDays(random_int(1, 29));
                $to = (clone $from)->addDays(random_int(0, 30));

                $booking = Booking::make([
                    'from' => $from,
                    'to' => $to,
                    'price' => random_int(200, 5000)
                ]);

                $bookings->push($booking);
            }

            $bookable->bookings()->saveMany($bookings);
        });

        Bookable::all()->each(function (Bookable $bookable){
            $reviews = Review::factory(random_int(5, 30))->make();
            $bookable->reviews()->saveMany($reviews);
        });

    }
}
