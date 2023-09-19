<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            "message"=> fake()->text(100),            
            "name"=> fake()->name(),       
            "surname"=> fake()->lastname(),    
            "email"=> fake()->email(),
            "send_date" => fake()->dateTimeBetween('-10 years'),
        ];
    }
}
