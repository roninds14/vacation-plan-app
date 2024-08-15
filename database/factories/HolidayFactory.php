<?php

namespace Database\Factories;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayFactory extends Factory
{
	protected $model = Holiday::class;

	public function definition(): array
	{
		return [
			'title' => $this->faker->sentence,
			'description' => $this->faker->paragraph,
			'date' => $this->faker->date,
			'location' => $this->faker->city,
		];
	}
}
