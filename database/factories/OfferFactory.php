<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    protected $model=Offer::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'name'=>$this->faker->slug,
           'price'=>$this->faker->randomFloat(),
           'url'=>$this->faker->url,
           'description'=>$this->faker->text,
           'is_active'=>$this->faker->boolean,
        ];
    }
}
