<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model=Branch::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'en' => ['name' =>$this->faker->unique()->name,'short_description'=>$this->faker->sentence,'description' =>$this->faker->text],
            'ar' => ['name' => $this->faker->name,'short_description'=>$this->faker->sentence,'description' => $this->faker->text],

            'city'=>$this->faker->city,
            'address'=>$this->faker->address,
            'phone'=>$this->faker->phoneNumber,
            'whatsapp_phone'=>$this->faker->phoneNumber,
            'map_link'=>$this->faker->url,
            'is_active'=>$this->faker->boolean,
        ];
    }
}
