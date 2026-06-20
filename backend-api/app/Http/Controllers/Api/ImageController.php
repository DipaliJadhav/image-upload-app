<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageApp;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessImageJob;

class ImageController extends Controller
{
    public function index()
    {
        return ImageApp::where('user_id', auth()->id())
        ->latest()
        ->get();
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
            'message' => 'Image uploaded successfully'
        ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }
        else
            {
                return ImageApp::with('user')
                    ->latest()
                    ->paginate(5);
            }
         
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
        
        // if ($image->user_id != auth()->id()) {
        // return response()->json([
        //     'message' => 'Unauthorized'
        // ],403);
        // }
        $this->authorize('delete', $image);
        Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return response()->json([
        'message' => 'Image deleted successfully'
        ]);
    }
}
