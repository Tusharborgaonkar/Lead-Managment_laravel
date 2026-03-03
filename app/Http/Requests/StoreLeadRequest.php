<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
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
            'customer_type' => 'required|string|in:new,existing',
            'customer_id' => 'required_if:customer_type,existing|exists:customers,id|nullable',
            'client_name' => 'required_if:customer_type,new|string|max:255|nullable',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'project_name' => 'required|string|max:255',
            'status' => 'required|string|in:Pending,Confirm,Not Interested,Followup',
        ];
    }
}
