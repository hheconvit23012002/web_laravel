<?php

namespace App\Http\Requests\Course;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => [
                'bail',
                'required',
                'string',
                Rule::unique(Course::class)->ignore($this->course),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attribute ko dc trong',
            'name.unique' => ':attribute ko dc trung',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
        ];
    }
}
