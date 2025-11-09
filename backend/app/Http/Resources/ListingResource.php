<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource {
    public function toArray($request){
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'address'=>$this->address,
            'videos'=>VideoResource::collection($this->whenLoaded('videos')),
        ];
    }
}
