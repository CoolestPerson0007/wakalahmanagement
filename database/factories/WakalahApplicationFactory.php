<?php

namespace Database\Factories;

use App\WakalahApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class WakalahApplicationFactory extends Factory 
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = WakalahApplication::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->title(),
            'last_name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'ic_number' => $this->faker->numerify('######-##-####'),
            'phone' => $this->faker->numerify('+60##########'),
            'wakalah_type' => $this->faker->randomElement(['individual', 'institution(Bank)' , 'institution(Government Organisation)', 'institution(Non-Government Organisation)', 'institution(Education)', 'institution(Government Linked Company)', 'institution(Mosque/Surau)']),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->randomNumber(5,true),
            'bank_account' => $this->faker->bankAccountNumber(),
            'bank_name' => $this->faker->randomElement(['affin', 'agro', 'alliance', 'am', 'islam', 'muamalat', 'rakyat', 'simpanan', 'cimb', 'hong_leong', 'hsbc', 'kuwait_finance', 'maybank', 'ocbc', 'public', 'rhb', 'sc', 'uob']),
            'status_id' => 3,
 
        ];
    }
}
