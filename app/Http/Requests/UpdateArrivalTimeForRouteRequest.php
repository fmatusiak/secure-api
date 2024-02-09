<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArrivalTimeForRouteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'route_id' => ['required', 'integer', 'exists:routes,id'],
            'route_point_id' => ['required', 'integer', 'exists:route_points,id'],
            'order' => ['required', 'integer'],
            'arrival_time' => ['required', 'date_format:H:i:s'],
        ];
    }
}
