<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(30),
            'user_id' => 1,
            'lang' => 'ru',
            'slug' => 'ru',
            'meta_title' => 'meta_title',
            'meta_descriptions' => 'meta_descriptions',
        ];
    }
}
