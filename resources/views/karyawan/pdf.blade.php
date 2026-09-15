<style>
body { font-family: DejaVu Sans, sans-serif; color:#172033; margin:0; }
.wrap { padding:22px 26px; }
.header { background:#ff3038; color:#fff; padding:16px 20px; border-radius:8px; text-align:center; }
.header h1 { margin:0; font-size:19px; letter-spacing:.3px; }
.header p { margin:5px 0 0; font-size:10.5px; opacity:.92; }
.info-box { background:#fff5f5; border:1px solid #ffd7d9; border-radius:8px; padding:12px 16px; margin-top:16px; font-size:11.5px; }
.info-box table,.cols,.section-box table,.net-box table { width:100%; border-collapse:collapse; }
.info-box td { padding:3px 0; border:0; }.info-box td.label { width:100px; color:#42516a; }
.cols { border-spacing:9px 0; margin-top:16px; }.cols td { vertical-align:top; width:50%; }
.section-box { border:1px solid #e7ebf0; border-radius:8px; padding:12px 14px 6px; }
.section-box h2 { font-size:10.5px; text-transform:uppercase; color:#42516a; margin:0 0 10px; text-align:center; }
.section-box td { padding:5px 0; border:0; font-size:11px; }.val { text-align:right; }
.total-row td { border-top:1px solid #e7ebf0 !important; padding-top:8px !important; font-weight:700; }
.net-box { margin-top:16px; background:#fff0f1; border:1px solid #ffc4c8; border-radius:8px; padding:14px 18px; }
.net-box td { border:0; padding:0; }.lbl { font-size:12px; font-weight:700; }.amt { font-size:19px; font-weight:700; color:#ff3038; text-align:right; }
.footer { margin-top:22px; font-size:9.5px; color:#94a3b8; text-align:center; }
</style>
<div class="wrap">
<div class="header"><h1>Slip Gaji Karyawan</h1><p>Periode : {{ $periode }}</p></div>
<div class="info-box"><table>
<tr><td class="label">Nama</td><td>: <b>{{ $karyawan->nama }}</b></td></tr>
<tr><td class="label">NIK</td><td>: {{ $karyawan->nik }}</td></tr>
<tr><td class="label">Jabatan</td><td>: {{ $karyawan->jabatan }}</td></tr>
</table></div>
<table class="cols"><tr><td><div class="section-box"><h2>Penghasilan</h2><table>
<tr><td>Gaji Pokok</td><td class="val">Rp {{ number_format((float)$karyawan->gaji_pokok,0,',','.') }}</td></tr>
<tr><td>Lembur</td><td class="val">Rp {{ number_format((float)$karyawan->lembur,0,',','.') }}</td></tr>
<tr class="total-row"><td>Total Penghasilan</td><td class="val">Rp {{ number_format((float)$karyawan->total_penghasilan,0,',','.') }}</td></tr>
</table></div></td>
<td><div class="section-box"><h2>Potongan</h2><table>
<tr><td>Pinjaman Karyawan</td><td class="val">Rp {{ number_format((float)$karyawan->pinjaman,0,',','.') }}</td></tr>
<tr class="total-row"><td>Total Potongan</td><td class="val">Rp {{ number_format((float)$karyawan->total_potongan,0,',','.') }}</td></tr>
</table></div></td></tr></table>
<div class="net-box"><table><tr><td class="lbl">Gaji Bersih</td><td class="amt">Rp {{ number_format((float)$karyawan->gaji_bersih,0,',','.') }}</td></tr></table></div>
<div class="footer">Dokumen ini dibuat otomatis oleh sistem penggajian.</div>
</div>
