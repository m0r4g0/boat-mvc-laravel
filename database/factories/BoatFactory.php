<?php

namespace Database\Factories;

use App\Models\Boat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class BoatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Boat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;

        return [
            'name' => $name,
            'category' => $this->faker->randomElement(['sailing-yacht', 'motor-boat']),
            'slug' => Str::slug($name),
            'user_id' => 1
        ];
    }
}