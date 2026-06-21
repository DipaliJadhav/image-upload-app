<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageApp;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessImageJob;
use App\Http\Resources\ImageResource;

class ImageController extends Controller
{
    public function index()
    {
        $images = ImageApp::where('user_id', auth()->id())
        ->latest()
        ->paginate(4);
        return ImageResource::collection($images);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }
        else
        {    

        $request->validate([
            'label' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $path = $request->file('image')->store('uploads', 'public');

        $image = ImageApp::create([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'image_path' => $path,
            'status' => 'pending',
        ]);
        ProcessImageJob::dispatch($image);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'image' => new ImageResource($image),
        ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function feed()
    {
        $images = ImageApp::latest()
        ->paginate(4);

        return ImageResource::collection($images);
         
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageApp $imageApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImageApp $imageApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImageApp $image)
    {
        

        $this->authorize('delete', $image);
        Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return response()->json([
        'message' => 'Image deleted successfully'
        ]);
    }
}
