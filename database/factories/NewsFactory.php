<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft', 'published', 'archived']);

        return [
            'title' => $this->faker->sentence(4),
            'excerpt' => $this->faker->optional()->sentence(12),
            'content' => $this->faker->paragraphs(3, true),
            'image' => null,
            'featured_image' => null,
            'status' => $status,
            'featured' => $this->faker->boolean(10),
            'published_at' => $status === 'published' ? now() : null,
            'user_id' => User::factory(),
            'group_id' => Group::factory(),
            'created_by' => User::factory(),
            'scope' => 'parish',
        ];
    }
}
