<?php

namespace Database\Factories;

use App\Models\FishingLicence;
use Illuminate\Database\Eloquent\Factories\Factory;

class FishingLicenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FishingLicence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>$this->faker->randomFloat(0,1,11),
            'address'=>$this->faker->address(),
            'number_of_rods'=>$this->faker->randomFloat(0,0,128),
            'number_of_fishing_hooks'=>$this->faker->randomFloat(0,0,128),
            'valid_from'=>$this->faker->date,
            'valid_to'=>$this->faker->date,
            'region'=>$this->faker->city(),
            'status'=>$this->faker->boolean,
            'price'=>$this->faker->randomFloat(0,0,200)
        ];
    }
}
