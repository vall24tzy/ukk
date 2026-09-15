<?php

namespace App\Http\Requests;

use App\Models\Karyawan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKaryawanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $karyawan = $this->route('karyawan');

        return [
            'nama' => ['required', 'string', 'max:150'],
            'nik' => ['required', 'string', 'max:50', Rule::unique('karyawan', 'nik')->ignore($karyawan instanceof Karyawan ? $karyawan->id : $karyawan)],
            'jabatan' => ['required', 'string', 'max:150'],
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
            'lembur' => ['required', 'numeric', 'min:0'],
            'pinjaman' => ['required', 'numeric', 'min:0'],
        ];
    }
}
