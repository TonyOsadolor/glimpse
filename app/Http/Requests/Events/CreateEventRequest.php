<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateEventRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_name' => [
                'required', 'string',
                Rule::unique('events')->where(function ($query) {
                    return $query->where('company_id', Auth::user()->id);
                }),
            ],
            'event_desc' => ['required', 'string'],
            'event_category_id' => ['required', 'exists:event_categories,id'],
            'max_participants' => ['required'],
            'start_time' => [
                'required',
                'date',
                'date_format:Y-m-d H:i:s',
            ],
            'end_time' => [
                'required', 
                'date',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }

    /**
     * Get the error Messages for the defined Validation Rules
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'event_name.required' => 'Please provide an :attribute',
            'event_name.string' => ':attribute must be a string',
            'event_name.unique' => 'You already have :attribute with same name',

            'event_desc.required' => ':attribute is required',
            'event_desc.string' => ':attribute must be a string',

            'event_category_id.required' => ':attribute is required',
            'event_category_id.exists' => 'Invalid :attribute provided',

            'max_participants.required' => ':attribute is required',

            'start_time.required' => ':attribute is required',
            'start_time.date_format' => 'provide a :attribute format',

            'end_time.required' => ':attribute is required',
            'end_time.date_format' => 'provide a :attribute format',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (strtotime($this->start_time) < strtotime(now())) {
                    $validator->errors()->add(
                        'start_time', "Event start time must be a date after: '".now()."'",
                    );
                }

                if (strtotime($this->end_time) < strtotime($this->start_time)) {
                    $validator->errors()->add(
                        'end_time', "Event end time cannot be before or equal '".$this->input('start_time')."'",
                    );
                }
            }
        ];
    }
}
