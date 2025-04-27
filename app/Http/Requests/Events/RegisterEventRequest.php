<?php

namespace App\Http\Requests\Events;

use App\Models\Event;
use App\Models\RegisterEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterEventRequest extends FormRequest
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
            'event_id' => [
                'required',
                'exists:events,uuid',     
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
            'event_id.required' => ':attribute is required',
            'event_id.exists' => 'event doesn\'t exists',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    // public function after(): array
    // {
        /* $user = Auth::user();
        $event = Event::whereUuid($this->event_id)->first();
        $pastRegistration = RegisterEvent::where('user_id', $user->id)
            ->where('event_id', $event->id)->first();
        return [
            function (Validator $validator) use ($pastRegistration){
                if ($pastRegistration) {
                    $validator->errors()->add(
                        'event_id', "You have already Registered for this Event!",
                    );
                }
            }
        ]; */
    // }
}
