<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model=Service::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id'=>Category::factory()->create(),
            'name'=>$this->faker->unique()->name,
            'short_description'=>$this->faker->sentence,
            'description'=>$this->faker->text,
            'is_active'=>$this->faker->boolean,
        ];
    }
}
