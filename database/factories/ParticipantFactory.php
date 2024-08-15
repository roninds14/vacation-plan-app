<?php

namespace Database\Factories;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'holiday_id' => HolidayFactory::factory(),
            'name' => $this->faker->name,
        ];
    }
}
