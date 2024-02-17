<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class AddBookRequest extends FormRequest
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
            'judul' => ['required','string', 'max:100'],
            'penulis' => ['required','string', 'max:100'],
            'penerbit' => ['required','string', 'max:100'],
            'tahun_terbit' => ['required','integer'],
        ];
    }
    public function messages()
    {
        return [
            'judul.required' => 'Judul harus diisi.',
            'penulis.required' => 'Penulis harus diisi.',
            'penerbit.required' => 'Penerbit harus diisi.',
            'tahun_terbit.required' => 'Tahun terbit harus diisi.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
