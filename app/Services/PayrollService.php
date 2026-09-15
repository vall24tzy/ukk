<?php

namespace App\Services;

class PayrollService
{
    public function calculate(float|int|string $gajiPokok, float|int|string $lembur, float|int|string $pinjaman): array
    {
        $totalPenghasilan = (float) $gajiPokok + (float) $lembur;
        $totalPotongan = (float) $pinjaman;

        return [
            'total_penghasilan' => $totalPenghasilan,
            'total_potongan' => $totalPotongan,
            'gaji_bersih' => $totalPenghasilan - $totalPotongan,
        ];
    }

    public function rupiah(float|int|string $value): string
    {
        return 'Rp '.number_format((float) $value, 0, ',', '.');
    }
}
