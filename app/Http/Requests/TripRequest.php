<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|max:255',
                    'description' => 'required|string|max:255',
                    'budged_estimation' => 'required|integer',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|string|max:255',
                    'description' => 'required|string|max:255',
                    'budged_estimation' => 'required|integer',
                ];

            default:
                break;
        }
    }
}
