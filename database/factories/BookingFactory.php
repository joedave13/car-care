<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Store;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'store_id' => Store::factory(),
            'service_id' => Service::factory(),
            'booking_date' => $this->faker->date(),
            'booking_time' => $this->faker->time(),
            'service_price' => $this->faker->numberBetween(-100000, 100000),
            'booking_fee' => $this->faker->numberBetween(-100000, 100000),
            'tax' => $this->faker->numberBetween(-100000, 100000),
            'total' => $this->faker->numberBetween(-100000, 100000),
            'status' => $this->faker->word(),
            'payment_proof' => $this->faker->word(),
        ];
    }
}
