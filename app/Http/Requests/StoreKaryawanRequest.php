<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKaryawanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'nik' => ['required', 'string', 'max:50', 'unique:karyawan,nik'],
            'jabatan' => ['required', 'string', 'max:150'],
            'periode_awal' => ['required', 'date'],
            'periode_akhir' => ['required', 'date', 'after_or_equal:periode_awal'],
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
            'lembur' => ['required', 'numeric', 'min:0'],
            'pinjaman' => ['required', 'numeric', 'min:0'],
            'captcha_answer' => ['required', 'integer'],
        ];
    }
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah digunakan.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'periode_awal.required' => 'Periode awal wajib diisi.',
            'periode_akhir.required' => 'Periode akhir wajib diisi.',
            'periode_akhir.after_or_equal' => 'Tanggal akhir periode tidak boleh sebelum tanggal awal.',
            'gaji_pokok.required' => 'Gaji pokok wajib diisi.',
            'lembur.required' => 'Lembur wajib diisi.',
            'pinjaman.required' => 'Pinjaman wajib diisi.',
            'captcha_answer.required' => 'Jawaban captcha wajib diisi.',
            'captcha_answer.integer' => 'Jawaban captcha harus berupa angka.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama',
            'nik' => 'NIK',
            'jabatan' => 'jabatan',
            'periode_awal' => 'periode awal',
            'periode_akhir' => 'periode akhir',
            'gaji_pokok' => 'gaji pokok',
            'lembur' => 'lembur',
            'pinjaman' => 'pinjaman',
            'captcha_answer' => 'jawaban captcha',
        ];
    }

}
