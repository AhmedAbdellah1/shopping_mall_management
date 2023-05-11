<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_name' => $this->faker->company,
            'brand_logo' => null,
            'company_name' => $this->faker->company,
            'tax_number' => $this->faker->randomNumber(9),
            'contact_person_name' => $this->faker->name,
            'contact_person_phone' => $this->faker->phoneNumber,
            'company_address' => $this->faker->address,
            'shop_location' => $this->faker->address,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
