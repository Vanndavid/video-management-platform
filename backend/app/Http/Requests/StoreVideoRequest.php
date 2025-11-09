<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest {
    public function rules(): array {
        return [
            'listing_id'=>['required','exists:listings,id'],
            'title'=>['required','string','max:255'],
            'source_url'=>['required','string','max:1024'],
        ];
    }
}
