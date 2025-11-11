<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Video;
use App\Models\VideoAsset;

class TranscodeVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $videoId;

    public function __construct(string $videoId)
    {
        $this->videoId = $videoId;
    }

    public function handle(): void
    {
        $video = Video::find($this->videoId);
        if (!$video) return;

        $video->update(['status' => 'PROCESSING']);
        sleep(2);

        // fake new assets
        $asset1080 = "/storage/videos/transcoded/{$video->id}/1080p.mp4";
        $thumb     = "/storage/videos/transcoded/{$video->id}/thumb.jpg";

        VideoAsset::create(['video_id'=>$video->id,'type'=>'TRANSCODED_1080P','url'=>$asset1080]);
        VideoAsset::create(['video_id'=>$video->id,'type'=>'THUMBNAIL','url'=>$thumb]);

        $video->update(['status'=>'READY']);
    }
}
