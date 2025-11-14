<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (!file_exists(public_path('uploads/general/media'))) {
            mkdir(public_path('uploads/general/media'), 0755, true);
        }
        
        // This generates the image and returns only the file name
        $imageFileName = $this->faker->image(public_path('uploads/general/media'), 640, 480, null, true);

        return [
            'title' => $this->faker->sentence,
            'title_ur' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'description_ur' => $this->faker->paragraph,
            'image' => 'uploads/general/media/' . $imageFileName,
            'meta_title' => $this->faker->sentence,
            'meta_description' => $this->faker->paragraph,
            'meta_keywords' => implode(', ', $this->faker->words(5)),
            'status' => 1,
        ];
    }
}
