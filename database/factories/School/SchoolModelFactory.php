<?php

namespace Database\Factories\School;

use App\Models\School\SchoolModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SchoolModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SchoolModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idcode'        => rand(100000000,1000000000), // 9 digit lenght
            'country_id'    => 6,
            'province_id'   => 39,
            'region_id'     => 6,
            'city_id'       => 1,
            'name'          => $this->faker->unique()->company(),
            'licence'       => Str::random(9),
            'phone'         => $this->faker->tollFreePhoneNumber(),
            'email'         => $this->faker->safeEmail(),
            'website'       => $this->faker->domainName(),
            'address'       => $this->faker->streetAddress(),
            'created_at'    => now(),
            'updated_at'    => now()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
