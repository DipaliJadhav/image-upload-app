<?php

namespace App\Jobs;

use App\Models\ImageApp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessImageJob implements ShouldQueue
{
    use Queueable;

    public $deleteWhenMissingModels = true;
     public function __construct(
        public ImageApp $image
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(5);
        if (! Storage::disk('public')->exists($this->image->image_path)) {
            $this->image->update([
                'status' => 'error',
            ]);
            return;
        }
    
        $path = Storage::disk('public')->path($this->image->image_path);
        Log::info([
            'path' => $path,
            'exists' => file_exists($path),
            'size' => filesize($path),
            'mime' => mime_content_type($path),
        ]);
        $this->image->update([
            'file_size' => filesize($path),
            'mime_type' => mime_content_type($path),
            'status' => 'processed',
        ]);
    }
}
