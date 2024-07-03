<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Company;
use App\Models\User;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [
            //
            "name" => $this->faker->sentence(),
            "description" => $this->faker->paragraph(),
            "user_id" => User::all()->random()->id,
            "is_completed" => rand(0,1),
            "company_id" => Company::all()->random()->id,
            "start_at" => date_format($this->faker->dateTimeInInterval('1 week'), "Y-m-d 00:00:00"),
            "expired_at" => date_format($this->faker->dateTimeInInterval('1 week', '+7 days'), "Y-m-d 00:00:00"),
        ];
    }
}
