<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFollowupRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:Call,Meeting,Email,Demo,Legal,Lead',
            'description' => 'required|string',
            'scheduled_at' => 'required|date',
            'status' => 'required|string|in:Pending,Completed,Cancelled',
            'lead_id' => 'nullable|exists:leads,id',
            'customer_id' => 'nullable|exists:customers,id',
            'deal_id' => 'nullable|exists:deals,id',
            'assigned_to' => 'nullable|exists:users,id'
        ];
    }
}
