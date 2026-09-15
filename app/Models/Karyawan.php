<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = [
        'nama',
        'nik',
        'jabatan',
        'periode_awal',
        'periode_akhir',
        'gaji_pokok',
        'lembur',
        'pinjaman',
        'total_penghasilan',
        'total_potongan',
        'gaji_bersih',
    ];

    protected function casts(): array
    {
        return [
            'periode_awal' => 'date',
            'periode_akhir' => 'date',
            'gaji_pokok' => 'decimal:2',
            'lembur' => 'decimal:2',
            'pinjaman' => 'decimal:2',
            'total_penghasilan' => 'decimal:2',
            'total_potongan' => 'decimal:2',
            'gaji_bersih' => 'decimal:2',
        ];
    }
}
