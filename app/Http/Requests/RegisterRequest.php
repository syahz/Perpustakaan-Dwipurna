<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class RegisterRequest extends FormRequest
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
            'name' => ['required','string', 'max:100'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','confirmed','min:8', 'regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/'],
            'role' => ['required','in:toko_buku,cafe,barista'],
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah ada.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung huruf kecil, huruf besar, dan angka.',
            'password.regex:/[a-z]/' => 'Password harus mengandung setidaknya satu huruf kecil.',
            'password.regex:/[A-Z]/' => 'Password harus mengandung setidaknya satu huruf besar.',
            'password.regex:/[0-9]/' => 'Password harus mengandung setidaknya satu angka.',
            'role.required' => 'Role harus diisi.',
        ];
    }
    

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
