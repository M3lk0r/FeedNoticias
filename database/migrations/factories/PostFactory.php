<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;
    
    public function definition()
    {
        return [
            'user_id'      => User::factory(),
            'title'        => $this->faker->sentence,
            'content'      => $this->faker->paragraph,
            'status'       => 'published',
            'published_at' => Carbon::now(),
            'scheduled_at' => null,
        ];
    }
}