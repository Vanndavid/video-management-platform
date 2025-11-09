<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Video extends Model {
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id','listing_id','title','source_url','status',
        'duration_seconds','width','height','thumbnail_url','error_message'
    ];
    protected static function booted() {
        static::creating(function($m){ if(!$m->id) $m->id = (string) Str::uuid(); });
    }
    public function listing(){ return $this->belongsTo(Listing::class); }
    public function assets(){ return $this->hasMany(VideoAsset::class); }
    public function events(){ return $this->hasMany(VideoEvent::class); }
}
