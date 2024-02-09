<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignRoutePointsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'route_points' => ['array', 'required'],
            'route_points.*.id' => ['required', 'integer', 'exists:route_points,id'],
            'route_points.*.order' => ['required', 'integer'],
            'route_points.*.arrival_time' => ['nullable', 'date_format:H:i:s'],
        ];
    }
}
