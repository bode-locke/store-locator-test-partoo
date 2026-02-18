<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreSearchRequest extends FormRequest
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
            'n' => ['required', 'numeric', 'between:-90,90'],
            's' => ['required', 'numeric', 'between:-90,90'],
            'e'  => ['required', 'numeric', 'between:-180,180'],
            'w'  => ['required', 'numeric', 'between:-180,180'],
            'services' => ['array'],
            'services.*' => ['integer', 'exists:services,id'],
            'operator' => ['nullable', 'in:AND,OR'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {

            $n = $this->input('n');
            $s = $this->input('s');
            $e = $this->input('e');
            $w = $this->input('w');

            if ($s > $n) {
                $validator->errors()->add('s', 'South must be lower than North');
            }

            if ($w > $e) {
                $validator->errors()->add('w', 'West must be lower than East');
            }
        });
    }
}
