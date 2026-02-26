<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'optional_phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'source' => 'nullable|string|max:100',
            'category' => 'required|string|in:Not Interested,Followup,Pending,Confirm',
            'value' => 'nullable|numeric',
            'description' => 'nullable|string',
            'followup_methods' => 'nullable|array',
            'followup_methods.*' => 'string|in:whatsapp,email,cold_call',
            'followup_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id'
        ];
    }
}
