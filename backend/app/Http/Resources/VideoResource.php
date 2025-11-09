<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource {
    public function toArray($request){
        return [
            'id'=>$this->id,
            'listing_id'=>$this->listing_id,
            'title'=>$this->title,
            'source_url'=>$this->source_url,
            'status'=>$this->status,
            'duration_seconds'=>$this->duration_seconds,
            'width'=>$this->width,
            'height'=>$this->height,
            'thumbnail_url'=>$this->thumbnail_url,
            'error_message'=>$this->error_message,
            'assets'=>VideoAssetResource::collection($this->whenLoaded('assets')),
            'created_at'=>$this->created_at,
        ];
    }
}
