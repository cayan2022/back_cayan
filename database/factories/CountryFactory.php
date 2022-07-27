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
            'code'=>'+'.$this->faker->unique()->randomNumber(3),
            'en' => ['name' =>$this->faker->country],
            'ar' => ['name' => $this->localFaker()->country], //please don't change it to normal faker ,it helps to create arabic country
        ];
    }
}
