<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Jobs\ProcessImageJob;
use App\Models\ImageApp;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProcessImageJobTest extends TestCase
{
    use RefreshDatabase;
    public function test_process_image_job_updates_metadata(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg');

        $path = $file->store('images', 'public');

        $image = ImageApp::factory()->create([
            'image_path' => $path,
            'status' => 'pending',
        ]);

        $job = new ProcessImageJob($image);

        $job->handle();

        $image->refresh();

        $this->assertEquals('processed', $image->status);

        $this->assertNotNull($image->file_size);

        $this->assertNotNull($image->mime_type);
    }
}
