@extends('layouts.app')

@section('title', ($mode === 'edit' ? 'Edit' : 'Tambah').' Data')
@section('body_class', 'form-page')
@section('content')
<div class="form-shell">
    <a class="form-back" href="{{ route('karyawan.index') }}">&larr; Kembali ke daftar</a>

    <div class="salary-card">
        <h1>{{ $mode === 'edit' ? 'EDIT' : 'TAMBAH' }} DATA KARYAWAN</h1>
        <div class="separator"></div>
        @if ($mode === 'tambah')
            <div class="form-periode"><span>Periode Gaji</span><strong>{{ mb_strtolower(\Illuminate\Support\Carbon::parse($data['periode_awal'])->translatedFormat('d M').' - '.\Illuminate\Support\Carbon::parse($data['periode_akhir'])->translatedFormat('d M Y')) }}</strong></div>
        @else
            @if ($karyawan->periode_awal && $karyawan->periode_akhir)
                <div class="form-periode"><span>Periode Gaji</span><strong>{{ mb_strtolower($karyawan->periode_awal->translatedFormat('d M').' - '.$karyawan->periode_akhir->translatedFormat('d M Y')) }}</strong></div>
            @endif
        @endif

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="post" action="{{ $mode === 'edit' ? route('karyawan.update', $karyawan) : route('karyawan.store') }}">
            @csrf
            @if ($mode === 'edit') @method('PUT') @endif
            @if ($mode === 'tambah')
                <input type="hidden" name="periode_awal" value="{{ old('periode_awal', $data['periode_awal']) }}">
                <input type="hidden" name="periode_akhir" value="{{ old('periode_akhir', $data['periode_akhir']) }}">
            @endif

            <div class="basic-fields">
                <div class="form-row"><label>NAMA</label><span>:</span><input name="nama" value="{{ old('nama', $data['nama']) }}" required></div>
                <div class="form-row"><label>NIK</label><span>:</span><input name="nik" value="{{ old('nik', $data['nik']) }}" required></div>
                <div class="form-row"><label>JABATAN</label><span>:</span><input name="jabatan" value="{{ old('jabatan', $data['jabatan']) }}" required></div>
            </div>

            <div class="salary-grid">
                <section>
                    <h2>PENGHASILAN</h2>
                    <div class="money-row"><label>Gaji Pokok</label><input class="money" id="gaji" name="gaji_pokok" type="number" value="{{ old('gaji_pokok', $data['gaji_pokok']) }}" min="0"></div>
                    <div class="money-row"><label>Lembur</label><input class="money" id="lembur" name="lembur" type="number" value="{{ old('lembur', $data['lembur']) }}" min="0"></div>
                    <div class="line"></div>
                    <div class="money-row"><label>Total Penghasilan</label><input id="total" readonly></div>
                </section>
                <section>
                    <h2>POTONGAN</h2>
                    <div class="money-row"><label>Pinjaman Karyawan</label><input class="money" id="pinjaman" name="pinjaman" type="number" value="{{ old('pinjaman', $data['pinjaman']) }}" min="0"></div>
                    <div class="line"></div>
                    <div class="money-row"><label>Total Potongan</label><input id="potongan" readonly></div>
                </section>
            </div>

            <div class="net"><h2>GAJI BERSIH</h2><input id="bersih" readonly></div>

            @if ($mode !== 'edit')
            <div class="captcha">
                <div class="captcha-title"><strong>Captcha :</strong><a href="{{ route('karyawan.captcha.refresh', ['periode_awal' => $data['periode_awal'], 'periode_akhir' => $data['periode_akhir']]) }}">&#8635;</a></div>
                <div class="captcha-question">{{ $captchaA }} × {{ $captchaB }} = ?</div>
                <input name="captcha_answer" type="number" placeholder="Jawaban" required>
            </div>
            @endif

            <button class="submit" type="submit">{{ $mode === 'edit' ? 'Simpan Perubahan' : 'Submit' }}</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/form-karyawan.js') }}"></script>
@endpush
