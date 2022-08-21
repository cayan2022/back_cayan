<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Order;
use App\Models\Source;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model=Order::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'patient_name' => $this->faker->name,
//            'patient_phone' => $this->faker->phoneNumber,
            'user_id' => User::inRandomOrder()->take(1)->first()->id,
            'category_id' => Category::factory()->create(),
            'source_id' => Source::factory()->create(),
            'status_id' => Status::factory()->create(),
        ];
    }
}
