<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

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
            'slug' => $this->faker->sentence(16),
            'meta_title' => $this->faker->sentence(),
            'meta_descriptions' => $this->faker->paragraph(20),
        ];
    }
}
