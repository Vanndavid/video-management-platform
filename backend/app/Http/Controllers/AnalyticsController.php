<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoEventRequest;
use App\Models\VideoEvent;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function store(VideoEventRequest $request, string $id)
    {
        $video = Video::findOrFail($id);
        $validated = $request->validated();

        VideoEvent::create([
            'video_id'   => $video->id,
            'event_type' => $validated['event_type'],
            'user_agent' => $request->userAgent(),
            'ip'         => $request->ip(),
        ]);

        return response()->json(['ok' => true]);
    }

    public function topVideos()
    {
        $rows = DB::table('video_events')
            ->select('video_id', DB::raw('count(*) as plays'))
            ->groupBy('video_id')
            ->orderByDesc('plays')
            ->limit(5)
            ->get();

        return response()->json($rows);
    }

    public function health()
    {
        return response()->json(['ok' => true]);
    }
}
