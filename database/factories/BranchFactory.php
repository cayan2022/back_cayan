<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Helpers\Traits\CustomFactoryLocal;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'en' => [
                'name' => $this->faker->name,
                'short_description' => $this->faker->sentence,
                'full_description' => $this->faker->text
            ],
            'ar' => [
                'name' => $this->localFaker()->company,
                'short_description' => $this->localFaker()->realText(),
                'full_description' => $this->localFaker()->realText()
            ],

            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'whatsapp' => $this->faker->phoneNumber,
            'map' => $this->faker->url,
            'is_block' => $this->faker->boolean,
        ];
    }
}
