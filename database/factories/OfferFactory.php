<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model=Offer::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'en' => [
                'name' =>$this->faker->realText(50),
                'description' =>$this->faker->text,
            ],
            'ar' => [
                'name' =>$this->localFaker()->realText(50),
                'description' =>$this->localFaker()->realText(),
            ],
           'price'=>$this->faker->numberBetween(1,1000),
           'url'=>$this->faker->url,
           'is_block'=>$this->faker->boolean,
           'discount_percentage'=>$this->faker->numberBetween(0,100),
        ];
    }
}
