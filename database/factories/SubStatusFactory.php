<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\SubStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubStatusFactory extends Factory
{
    protected $model=SubStatus::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'status_id' => Status::factory()->create()
        ];
    }
}
