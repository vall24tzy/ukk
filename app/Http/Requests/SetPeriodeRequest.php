<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetPeriodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:karyawan,id'],
            'periode_awal' => ['required', 'date'],
            'periode_akhir' => ['required', 'date', 'after_or_equal:periode_awal'],
        ];
    }
}
