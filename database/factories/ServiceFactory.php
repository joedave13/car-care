<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Service;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'price' => $this->faker->numberBetween(-100000, 100000),
            'description' => $this->faker->text(),
            'photo' => $this->faker->word(),
            'duration_in_hour' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
