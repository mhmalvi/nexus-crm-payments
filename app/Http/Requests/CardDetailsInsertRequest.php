<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardDetailsInsertRequest extends FormRequest
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
            'data.card_number' => 'required|min:16|max:16|unique:card_details',
            'data.exp_date' => 'required',
            'data.cvc' => 'required|max:3|min:3',
            'data.user_id' => 'required|unique:card_details',
            'data.client_id' => 'required|unique:card_details',
            'data.type' => 'required',
            'data.name' => 'required',
            'data.email' => 'email|unique:card_details'
        ];
    }
}
