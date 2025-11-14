<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $redirectionType = $this->faker->randomElement([1, 2, 3]);
        return [
            'title' => $this->faker->sentence,
            'title_ur' => $this->faker->sentence,
            'redirection_type' => $redirectionType,
            'page_id' => $redirectionType === 1 ? \App\Models\Page::inRandomOrder()->value('id') ?? 1 : null,
            'route' => $redirectionType === 2 ? $this->faker->randomElement([
                'homepage', 'testing', 'testing2'
            ]) : null,
            'url' => $redirectionType === 3 ? $this->faker->url : null,
            'status' => 1,
        ];
    }
}
