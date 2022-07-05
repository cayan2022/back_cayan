<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    use CustomFactoryLocal;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name'=>['en' => $this->faker->country, 'ar' => $this->localFaker()->country],
            'code'=>'+'.$this->faker->randomNumber(3)
        ];
    }
}
