<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model=Testimonial::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'user_name'=>$this->faker->name,
           'comment'=>$this->faker->text,
            'is_block'=>$this->faker->boolean,
        ];
    }
}
