<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        switch($this->segment(4)) {
            case 'info':
                return $this->infoRules();
                break;

            case 'picture':
                return $this->pictureRules();
                break;

            default:
                break;
        }
    }

    public function infoRules()
    {
        return [
            'name' => 'required|string',
            'about_me' => 'nullable|string',
            'address' => 'nullable|string',
            'interest' => 'nullable|string',
            'birth_of_date' => 'required|date',
        ];
    }

    public function pictureRules()
    {
        return [
            'picture' => 'required|image|mimes:jpg,jpeg,png'
        ];
    }
}
