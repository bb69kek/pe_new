<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHaltRequest extends FormRequest
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
            'target' => 'required|string|max:255',
            'port' => 'required|integer',
            'method' => 'required|string|max:255',
            'duration' => 'required|integer',
            'day' => 'required|string|max:255',
            'hour' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'slots' => 'required|integer|gt:0'
        ];
    }
}
