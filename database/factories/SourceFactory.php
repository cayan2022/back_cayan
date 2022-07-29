<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    protected $model=Source::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'en' => [
                'name' =>$this->faker->unique()->name,
                'short_description'=>$this->faker->sentence,
                'description' =>$this->faker->text
            ],
            'ar' => [
                'name' =>$this->faker->unique()->name,
                'short_description'=>$this->faker->sentence,
                'description' => $this->faker->text
            ],
            'identifier'=>$this->faker->slug,
            'is_active'=>$this->faker->boolean,
        ];

    }
}
