<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoAsset extends Model {
    protected $fillable=['video_id','type','url','size_bytes'];
    public function video(){ return $this->belongsTo(Video::class); }
}
