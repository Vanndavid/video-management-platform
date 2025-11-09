<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoAssetResource extends JsonResource {
    public function toArray($request){
        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'url'=>$this->url,
            'size_bytes'=>$this->size_bytes,
        ];
    }
}
