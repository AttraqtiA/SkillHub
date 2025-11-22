<?php

namespace Database\Factories;

use App\Models\Participant;
use App\Models\CourseClass;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParticipantClass>
 */
class ParticipantClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'participant_id' => Participant::factory(),
            'class_id'       => CourseClass::factory(),
            'enrolled_at'    => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status'         => $this->faker->randomElement(['active', 'completed', 'cancelled']),
            'grade'          => $this->faker->randomElement(['A', 'B', 'C', null]),
            'progress'       => $this->faker->numberBetween(0, 100),
        ];
    }
}
