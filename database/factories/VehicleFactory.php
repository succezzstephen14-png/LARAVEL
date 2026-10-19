<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'make' => $this->faker->randomElement(['Ford', 'Chevrolet', 'Ram', 'GMC', 'Peterbilt', 'Kenworth', 'Volvo', 'Mack']),
            'model' => $this->faker->randomElement(['F-150', 'Silverado', '1500', '2500', '379', 'W900', 'VNL', 'Granite']),
            'year' => $this->faker->numberBetween(2015, 2024),
            'license_plate' => strtoupper($this->faker->unique()->bothify('???-####')),
            'vehicle_type' => $this->faker->randomElement(['car', 'van', 'truck', 'motorcycle']),
            'status' => $this->faker->randomElement(['available', 'unavailable', 'maintenance']),
            'description' => $this->faker->sentence(),
            'image_url' => null,
            'capacity' => $this->faker->numberBetween(1000, 50000),
        ];
    }
}