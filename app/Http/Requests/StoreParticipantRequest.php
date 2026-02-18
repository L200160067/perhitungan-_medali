<?php

namespace App\Http\Requests;

use App\Enums\ParticipantGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $genderValues = array_map(fn (ParticipantGender $gender) => $gender->value, ParticipantGender::cases());

        return [
            'dojang_id' => 'required|integer|exists:dojangs,id',
            'name' => 'required|string|max:255',
            'gender' => [
                'required',
                'string',
                Rule::in($genderValues),
            ],
            'birth_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.image' => 'Foto harus berupa file gambar (JPG, PNG, atau WebP).',
            'photo.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'photo.max' => 'Ukuran foto maksimal 5MB.',
            'photo.uploaded' => 'Foto gagal diupload. Pastikan ukuran file tidak melebihi 5MB.',
        ];
    }
}
