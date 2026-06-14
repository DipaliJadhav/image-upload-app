<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ImageApp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImageApp>
 */
class ImageAppFactory extends Factory
{
    protected $model = ImageApp::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'label' => fake()->sentence(),
            'image_path' => 'images/test-image.jpg',
        ];
    }
}
