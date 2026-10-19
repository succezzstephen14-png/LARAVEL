<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'license_number' => $this->faker->unique()->bothify('DL-########'),
            'license_expiry' => $this->faker->dateTimeBetween('+1 year', '+5 years'),
            'license_class' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'experience_years' => $this->faker->numberBetween(1, 30),
            'status' => $this->faker->randomElement(['available', 'unavailable', 'on_duty']),
            'bio' => $this->faker->paragraph(),
            'profile_image' => null,
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'total_trips' => $this->faker->numberBetween(0, 500),
        ];
    }
}