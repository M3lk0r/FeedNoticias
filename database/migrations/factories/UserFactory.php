<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    
    public function definition()
    {
        return [
            'name'           => $this->faker->name,
            'email'          => $this->faker->unique()->safeEmail,
            'provider'       => 'microsoft',
            'provider_id'    => $this->faker->uuid,
            'role'           => 'user',
            'remember_token' => Str::random(10),
        ];
    }
}