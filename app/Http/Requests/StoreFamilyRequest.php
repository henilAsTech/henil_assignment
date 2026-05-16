<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthdate' => 'required|date|before:' . now()->subYears(21)->toDateString(),
            'mobile_no' => 'required|digits:10',
            'address' => 'required|string|max:500',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:10',
            'pincode' => 'required|digits:6',
            'marital_status' => 'required|string|in:married,unmarried',
            'wedding_date' => 'nullable|required_if:marital_status,married|date|before_or_equal:today',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hobbies' => 'nullable|array',
            'hobbies.*.id'   => 'nullable|integer|exists:hobbies,id',
            'hobbies.*.name' => 'nullable|required_with:hobbies|string|max:150',
            'members' => 'nullable|array',
            'members.*.id' => 'nullable|integer|exists:family_members,id',
            'members.*.name' => 'required|string|max:255',
            'members.*.birthdate' => 'required|date|before_or_equal:today',
            'members.*.marital_status' => 'required|string|in:married,unmarried',
            'members.*.wedding_date' => 'nullable|required_if:members.*.marital_status,married|date|before_or_equal:today',
            'members.*.education' => 'required|string|max:255',
            'members.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The family head name is required.',
            'surname.required' => 'The family head surname is required.',
            'birthdate.required' => 'The family head birthdate is required.',
            'mobile_no.required' => 'The mobile number is required.',
            'mobile_no.digits' => 'The mobile number must be 10 digits.',
            'address.required' => 'The address is required.',
            'state.required' => 'The state is required.',
            'city.required' => 'The city is required.',
            'pincode.required' => 'The pincode is required.',
            'pincode.digits' => 'The pincode must be exactly 6 digits.',
            'marital_status.required' => 'The marital status is required.',
            'wedding_date.required_if' => 'The wedding date is required when marital status is married.',
            'photo.image' => 'The photo must be an image.',
            'photo.mimes' => 'The photo must be a file of type: jpeg, png, jpg, webp.',
            'photo.max' => 'The photo may not be greater than 2MB.',
            
            'hobbies.*.required_with' => 'Hobby is required.',
            'hobbies.*.name.string' => 'Hobby must be a valid string.',
            'hobbies.*.name.max'    => 'Hobby may not exceed 150 characters.',
            'hobbies.*.id.exists'   => 'A submitted hobby ID is invalid.',
            
            'members.*.id.exists'   => 'A submitted member ID is invalid.',
            'members.*.name.required' => 'Member must have a name.',
            'members.*.birthdate.required' => 'Member must have a birthdate.',
            'members.*.birthdate.before_or_equal' => 'Member birthdate must be a past or present date.',
            'members.*.marital_status.required' => 'Member must have a marital status.',
            'members.*.wedding_date.required_if' => 'The wedding date is required for married family members.',
            'members.*.wedding_date.before_or_equal' => 'The wedding date for family members must be a past or present date.',
            'members.*.education.required' => 'Member must have an education field.',
            'members.*.photo.image' => 'Member photo must be an image.',
            'members.*.photo.mimes' => 'Member photo must be a file of type: jpeg, png, jpg, webp.',
            'members.*.photo.max' => 'Member photo may not be greater than 2MB.',
        ];
    }
}
