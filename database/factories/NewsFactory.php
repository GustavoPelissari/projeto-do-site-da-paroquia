<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first() ?? User::factory()->create();

        $group = null;
        if ($this->faker->boolean(30)) {
            $group = Group::query()->inRandomOrder()->first() ?? Group::factory()->create();
        }

        $status = $this->faker->randomElement(['draft', 'published', 'archived']);
        $publishedAt = $status === 'published' ? $this->faker->dateTimeBetween('-1 month', 'now') : null;

        return [
            'title' => $this->faker->sentence(5),
            'excerpt' => $this->faker->boolean(50) ? $this->faker->text(160) : null,
            'content' => $this->faker->paragraphs(4, true),
            'image' => null,
            'featured_image' => null,
            'status' => $status,
            'featured' => $this->faker->boolean(10),
            'user_id' => $user->id,
            'group_id' => $group?->id,
            'created_by' => $this->faker->boolean(70) ? $user->id : null,
            'scope' => 'parish',
            'published_at' => $publishedAt,
        ];
    }
}
