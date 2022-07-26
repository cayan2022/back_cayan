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

            'en' => [
                'name' =>$this->faker->name,
                'short_description' =>$this->faker->sentence,
                'description' =>$this->faker->text,
            ],
            'ar' => [
                'name' =>$this->faker->name,
                'short_description' =>$this->faker->sentence,
                'description' =>$this->faker->text,
            ],

            'category_id'=>Category::factory()->create(),
            'is_active'=>$this->faker->boolean,
        ];
    }
}
