<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Factory para o modelo News.
 *
 * Gera notícias com título, conteúdo e status (draft ou published). O campo
 * excerpt será opcional – se vazio, o modelo gerará automaticamente a partir
 * do conteúdo.
 */
class NewsFactory extends Factory
{
    /**
     * O nome da classe de modelo correspondente.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        $content = $this->faker->paragraphs(3, true);
        return [
            'title' => $this->faker->sentence(4),
            'excerpt' => null,
            'content' => $content,
            'image' => null,
            'featured_image' => null,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'featured' => false,
            'user_id' => User::factory(),
            'group_id' => null,
            'created_by' => null,
            'scope' => null,
            'published_at' => Carbon::now(),
        ];
    }
}