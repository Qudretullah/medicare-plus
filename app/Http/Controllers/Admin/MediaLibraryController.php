<?php

namespace App\Http\Controllers\Admin;
use App\Support\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaLibraryController extends Controller
{
    public function index(): View
    {
        $mediaFiles = MediaFile::latest()
            ->paginate(12);

        return view('admin.media-library.index', compact('mediaFiles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],
        ]);

        $image = $validated['image'];

        $path = $image->store('media-library', 'public');

       
try {
    $mediaFile = MediaFile::create([
        'original_name' => $image->getClientOriginalName(),
        'file_path' => $path,
        'mime_type' => $image->getMimeType(),
        'file_size' => $image->getSize(),
    ]);
} catch (\Throwable $exception) {
    Storage::disk('public')->delete($path);
    throw $exception;
}

// Record image upload activity
ActivityLogger::record(
    'media.uploaded',
    'Admin uploaded image: ' . $image->getClientOriginalName(),
    MediaFile::class,
    $mediaFile->id
);

return redirect()
    ->route('admin.media-library.index')
    ->with('success', 'Image uploaded successfully.');
}


    public function destroy(MediaFile $mediaFile): RedirectResponse
    {
        // Only allow deleting files owned by this media module.
        if (!str_starts_with($mediaFile->file_path, 'media-library/')) {
            abort(403);
        }

        // Keep the record if file deletion fails.
        if (
            Storage::disk('public')->exists($mediaFile->file_path) &&
            !Storage::disk('public')->delete($mediaFile->file_path)
        ) {
            return back()->with(
                'error',
                'Image could not be deleted. Please try again.'
            );
        }

        $mediaFile->delete();

        return redirect()
            ->route('admin.media-library.index')
            ->with('success', 'Image deleted successfully.');
    }
}
