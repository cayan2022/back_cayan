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
        $identifier=$this->faker->slug;
        $link=config('app.url')."/?_source=$identifier";
        return [
            'name'=>$this->faker->word(),
            'identifier'=>$identifier,
            'link'=>$link,
            'short_description'=>$this->faker->sentence,
            'description'=>$this->faker->text,
            'is_active'=>$this->faker->boolean,
        ];
    }
}
