<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoEvent extends Model {
    protected $fillable=['video_id','event_type','user_agent','ip'];
    public function video(){ return $this->belongsTo(Video::class); }
}
