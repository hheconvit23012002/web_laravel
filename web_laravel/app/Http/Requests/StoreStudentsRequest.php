<?php

namespace App\Http\Requests;

use App\Enums\StudentStatusEnum;
use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentsRequest extends FormRequest
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
            'name'=> [
                'required',
                'string',
            ],
            'gender'=> [
                'required',
                'boolean',
            ],
            'birthdate'=> [
                'required',
                'date',
                'before:today',
            ],
            'status'=> [
                'required',
                Rule::in(StudentStatusEnum::asArray()),
            ],
            'avatar'=> [
                'nullable',
                'file',
                'image',
            ],
            'course_id'=> [
                'required',
                Rule::exists(Course::class,'id'),
            ]
        ];
    }
}