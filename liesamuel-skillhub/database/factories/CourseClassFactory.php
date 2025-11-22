<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseClass>
 */
class CourseClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $end   = (clone $start)->modify('+'.rand(1, 4).' weeks');

        return [
            'title'           => $this->faker->sentence(3),
            'description'     => $this->faker->sentence(10),
            'instructor_name' => $this->faker->name(),
            'start_date'      => $start->format('Y-m-d'),
            'end_date'        => $end->format('Y-m-d'),
            'status'          => $this->faker->randomElement(['planned', 'ongoing', 'finished']),
            'duration'        => $this->faker->numberBetween(4, 40),
            'level'           => $this->faker->randomElement(['basic', 'intermediate', 'advanced']),
            'category'        => $this->faker->randomElement(['design', 'programming', 'video', 'public speaking']),
        ];
    }
}
