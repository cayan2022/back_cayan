<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model=Service::class;
    use CustomFactoryLocal;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'en' => [
                'name' =>$this->faker->unique()->realText(50),
                'description' =>$this->faker->text,
            ],
            'ar' => [
                'name' =>$this->localFaker()->unique()->realText(50),
                'description' =>$this->localFaker()->realText(100),
            ],

            'category_id'=>Category::inRandomOrder()->take(1)->first()->id,
            'is_block'=>$this->faker->boolean,
        ];
    }
}
