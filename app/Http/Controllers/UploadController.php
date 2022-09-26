<?php

namespace App\Http\Controllers;

use App\Models\ImageUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        dd("CREATE");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        if ($request->file('file')) {

            $image = $request->file('file');
            $disk = config('uploader.disk');
            $fileInfo = $image->getClientOriginalName();
            $filename = $fileInfo;
            $filePath = config('uploader.path') . '/' . $filename;
            $hash = ImageUpload::createHash();

            Storage::disk($disk)->put($filePath, $request->file('file')->get());

            ImageUpload::create([
                'expires_at' => Carbon::now()->addDays(1),
                'original_filename' => $filename,
                'filename' => $filePath,
                'hash' => $hash,
                'disk' => $disk,
            ]);
            return response()->json(
                [
                    'success' => $filename,
                    'hash' => $hash,
                ]);

        }

        return response()->json([
            'message' => 'There was an error uploading the image.'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ImageUpload $imageupload)
    {
        $disk = config('uploader.disk');
        $contents = Storage::disk($disk)->get($imageupload->filename);
        $mimeType = Storage::disk($disk)->mimeType($imageupload->filename);

        return response($contents)->header('Content-Type', $mimeType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ImageUpload  $imageupload
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ImageUpload $imageupload)
    {
        $input = $request->input();

        $expires_at = match ($input['expires_at']) {
            "1day" => Carbon::now()->addDays(1),
            "1week" => Carbon::now()->addWeek(1),
            "1month" => Carbon::now()->addMonth(1),
            "1view" => 1,
            "2view" => 2,
            default => null,
        };

        if (is_integer($expires_at)) {
            $imageupload->max_views = $expires_at;
        } else {
            $imageupload->expires_at = $expires_at;
        }

        $imageupload->save();


        return Redirect::route('image.show', [
            'imageupload' => $imageupload->hash
        ])->withMessage('Image saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
