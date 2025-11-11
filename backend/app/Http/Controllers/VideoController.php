<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Video;
use App\Models\VideoEvent;
use App\Models\VideoAsset;
use App\Jobs\TranscodeVideoJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function upload(Request $req)
    {
        $req->validate([
            'listing_id' => 'required',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimetypes:video/mp4,video/quicktime,video/webm|max:204800',
        ]);

        $path = $req->file('file')->store('videos/originals', 'public');
        $publicUrl = Storage::disk('public')->url($path);

        $video = Video::create([
            'listing_id' => $req->listing_id,
            'title' => $req->title,
            'source_url' => $publicUrl,
            'status' => 'UPLOADED',
        ]);

        $video->assets()->create([
            'type' => 'ORIGINAL',
            'url' => $publicUrl,
            'size_bytes' => $req->file('file')->getSize(),
        ]);
        if($video){
            $video->update(['status' => 'READY']);
            dispatch(new TranscodeVideoJob($video->id));
        }

        return response()->json(['data' => $video], 201);
    }

    public function show(string $id)
    {
        return Video::with('assets','listing')->findOrFail($id);
    }

    public function byListing(int $listingId)
    {
        $listing = Listing::findOrFail($listingId);
        return $listing->videos()->with('assets')->get();
    }

    public function index()
    {
        return Listing::with('videos.assets')->get();
    }

}
