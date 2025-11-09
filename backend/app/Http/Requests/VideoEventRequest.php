<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoEventRequest extends FormRequest {
    public function rules(): array {
        return [
            'event_type'=>['required','in:PLAY,COMPLETE'],
        ];
    }
}
