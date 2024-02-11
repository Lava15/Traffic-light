<?php

namespace App\Http\Requests;

use App\Enums\TrafficLightEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TrafficForwardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_color' => ['required', new Enum(TrafficLightEnums::class)],
        ];
    }
}
