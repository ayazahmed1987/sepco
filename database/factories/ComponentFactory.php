<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Component>
 */
class ComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'component_name' => $this->faker->unique()->slug(),
            'fields' => json_encode([
                [
                    'name' => 'full_name',
                    'type' => 'text',
                    'label' => 'Full Name',
                    'required' => true
                ],
                [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'Email Address',
                    'required' => true
                ]
            ]),
            'design' => "<x-input label='Full Name' name='full_name' required />
                         <x-input label='Email Address' name='email' type='email' required />",
            'status' => true,
        ];
    }
}
