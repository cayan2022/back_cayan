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
        $faker = \Faker\Factory::create('ar_JO');

        return [
            'en' => [
                'name' =>$this->faker->name,
            ],
            'ar' => [
                'name' =>$faker->firstName,
            ],
            'status_id' => Status::factory()->create()
        ];
    }
}
