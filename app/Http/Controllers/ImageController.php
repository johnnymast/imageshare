<?php

namespace App\Http\Controllers;

use App\Models\ImageUpload;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Get the image data.
     *
     * @param \App\Models\ImageUpload $imageupload
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function getImageData(ImageUpload $imageupload)
    {
        $disk = config('uploader.disk');
        $contents = Storage::disk($disk)->get($imageupload->filename);
        $mimeType = Storage::disk($disk)->mimeType($imageupload->filename);

        if ($imageupload->isExpired()) {
            return redirect()->route('image.expired');
        }

        return response($contents)->header('Content-Type', $mimeType);
    }

    /**
     * Show the image to the viewer.
     *
     * @param \App\Models\ImageUpload $imageupload
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showImage(ImageUpload $imageupload)
    {
        $url = route('image.data', [
            'imageupload' => $imageupload->hash
        ]);

        ++$imageupload->views;
        $imageupload->save();

        if ($imageupload->max_views > 0 && ($imageupload->views > $imageupload->max_views)) {
            $imageupload->expire();
        }

        if ($imageupload->isExpired()) {
            return redirect()->route('image.expired');
        }

        return view('image.show', [
            'imageupload' => $imageupload,
            'url' => $url
        ]);
    }
}
