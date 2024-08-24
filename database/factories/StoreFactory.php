<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\City;
use App\Models\CustomerService;
use App\Models\Store;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'city_id' => City::factory(),
            'thumbnail' => $this->faker->word(),
            'is_open' => $this->faker->boolean(),
            'is_full' => $this->faker->boolean(),
            'address' => $this->faker->text(),
            'phone' => $this->faker->phoneNumber(),
            'customer_service_id' => CustomerService::factory(),
        ];
    }
}
