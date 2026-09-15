@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('body_class', 'dashboard-page')
@section('content')
<div class="container">
<header class="top-card">
    <div><h1>Data Karyawan</h1><p>Daftar seluruh karyawan</p></div>
    <div class="header-actions">
        <button type="button" class="add add-data-btn" onclick="bukaModalTambahData()">&#65291; Tambah Data</button>
        <form method="post" action="{{ route('logout') }}" class="inline-form">@csrf<button class="logout" type="submit">Keluar</button></form>
    </div>
</header>

@if(session('success')) <div class="success">{{ session('success') }}</div> @endif
@if($errors->any()) <div class="error">{{ $errors->first() }}</div> @endif

<div class="table-card"><div class="table-wrap"><table>
<thead><tr><th>NAMA</th><th>NIK</th><th>JABATAN</th><th>PERIODE</th><th>AKSI</th></tr></thead>
<tbody>
@if($rows->isEmpty())
<tr><td colspan="5" class="empty">Belum ada data.</td></tr>
@endif
@foreach($rows as $r)
<tr>
<td><span class="avatar">{{ strtoupper(substr($r->nama, 0, 2)) }}</span><b>{{ $r->nama }}</b></td>
<td>{{ $r->nik }}</td><td>{{ $r->jabatan }}</td>
<td>
@if($r->periode_awal && $r->periode_akhir)
<span class="periode-badge">{{ mb_strtolower($r->periode_awal->translatedFormat('d M').' - '.$r->periode_akhir->translatedFormat('d M Y')) }}</span>
@else <span class="periode-badge kosong">Belum diatur</span> @endif
</td>
<td class="actions">
<a class="action-btn edit" href="{{ route('karyawan.edit',$r) }}">&#9998; Edit</a>
<form method="post" action="{{ route('karyawan.destroy',$r) }}" class="inline-form" onsubmit="return confirm('Yakin hapus data ini?')">@csrf @method('DELETE')<button class="action-btn delete" type="submit">&#9831; Hapus</button></form>
<a class="action-btn" target="_blank" href="{{ route('karyawan.pdf',$r) }}">&#128196; PDF</a>
<a class="action-btn" target="_blank" href="{{ route('karyawan.whatsapp',$r) }}">&#128172; WA</a>
</td>
</tr>
@endforeach
</tbody>
</table></div></div>

<div class="modal-overlay" id="modalTambahData">
<div class="modal-box modal-tambah-data-box">
<div class="modal-head"><h2>Pilih Periode Gaji</h2><button type="button" class="modal-close" onclick="tutupModalTambahData()">&times;</button></div>
<form method="get" action="{{ route('karyawan.create') }}" id="formTambahDataPeriode">
<div class="modal-body modal-add-body">
<p class="modal-hint">Tentukan bulan dan tahun. Sistem otomatis memakai tanggal 25 sampai tanggal 25 bulan berikutnya.</p>
<div class="periode-setting-grid">
<div class="periode-baru-field"><label for="bulanTambah">Bulan</label><select id="bulanTambah" name="bulan_tambah" onchange="hitungPeriodeTambahData()">
@foreach(range(1,12) as $bulan)<option value="{{ $bulan }}">{{ \Illuminate\Support\Carbon::create()->month($bulan)->translatedFormat('F') }}</option>@endforeach
</select></div>
<div class="periode-baru-field"><label for="tahunTambah">Tahun</label><select id="tahunTambah" name="tahun_tambah" onchange="hitungPeriodeTambahData()">@foreach(range(now()->year - 2, now()->year + 3) as $tahun)<option value="{{ $tahun }}">{{ $tahun }}</option>@endforeach</select></div>
</div>
<div class="periode-preview" id="previewPeriodeTambahData">25 {{ now()->translatedFormat('M') }} - 25 {{ now()->copy()->addMonth()->translatedFormat('M Y') }}</div>
<input type="hidden" name="periode_awal" id="periodeAwalTambahData">
<input type="hidden" name="periode_akhir" id="periodeAkhirTambahData">
</div>
<div class="modal-foot"><button type="button" class="btn-secondary" onclick="tutupModalTambahData()">Batal</button><button type="submit" class="btn-primary">Lanjut ke Form</button></div>
</form>
</div></div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/periode-modal.js') }}"></script>
<script>document.addEventListener('DOMContentLoaded', function(){ if (new URLSearchParams(window.location.search).get('open_add_period') === '1') bukaModalTambahData(); });</script>
@endpush
