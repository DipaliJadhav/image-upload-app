<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\ImageApp;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DeleteImageTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_delete_own_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Storage::disk('public')->put(
            'images/test.jpg',
            'fake-image-content'
        );

        $image = ImageApp::create([
            'user_id' => $user->id,
            'label' => 'Test Image',
            'image_path' => 'images/test.jpg'
        ]);

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader(
            'Authorization',
            'Bearer '.$token
        )->deleteJson(
            "/api/images/{$image->id}"
        );

        $response->assertStatus(200);

        $this->assertDatabaseMissing('image_apps', [
            'id' => $image->id
        ]);
    }

    public function test_user_cannot_delete_another_users_image(): void
    {
        $owner = User::factory()->create();

        $otherUser = User::factory()->create();

        $image = ImageApp::create([
            'user_id' => $owner->id,
            'label' => 'Test',
            'image_path' => 'images/test.jpg'
        ]);

        $token = $otherUser
            ->createToken('test')
            ->plainTextToken;

        $response = $this->withHeader(
            'Authorization',
            'Bearer '.$token
        )->deleteJson(
            "/api/images/{$image->id}"
        );

        $response->assertStatus(403);
    }
}
