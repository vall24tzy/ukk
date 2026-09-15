<?php

namespace App\Services;

use App\Models\Karyawan;

class WhatsappService
{
    public function url(Karyawan $karyawan, PayrollService $payroll): string
    {
        $message = "LAPORAN GAJI KARYAWAN\n"
            ."Nama: {$karyawan->nama}\n"
            ."NIK: {$karyawan->nik}\n"
            ."Jabatan: {$karyawan->jabatan}\n"
            .'Gaji Bersih: '.$payroll->rupiah($karyawan->gaji_bersih);

        return 'https://wa.me/?text='.rawurlencode($message);
    }
}
