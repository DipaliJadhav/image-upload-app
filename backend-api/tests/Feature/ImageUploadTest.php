<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_upload_image(): void
        {
            Storage::fake('public');

            $user = User::factory()->create();

            $token = $user->createToken('test')->plainTextToken;

            $file = UploadedFile::fake()->image('photo.jpg');

            $response = $this->withHeader(
                'Authorization',
                'Bearer ' . $token
            )->post('/api/images', [
                'label' => 'Test Image',
                'image' => $file
            ]);

            $response->assertStatus(200);
        }
}
