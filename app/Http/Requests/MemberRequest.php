<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
        return [
            'name' => 'required|max:100',
            'address' => 'required|max:300',
            'age' => 'required|numeric|max:99',
            'photo' => 'bail|image|mimes:jpeg,png,gif|max:10024',
        ];
    }
    public function messages()
    {
        return [
            'age.max' => 'The age may not be greater than 2 Numeral.',
            'photo.max' => 'The photo may not be greater than 10MB.'
        ];
    }
}
