<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Models\Karyawan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class KaryawanController extends Controller
{
    public function index(): View
    {
        return view('karyawan.index', ['rows' => Karyawan::latest('id')->get()]);
    }

    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->filled('periode_awal') || ! $request->filled('periode_akhir')) {
            return redirect()->route('karyawan.index', ['open_add_period' => 1]);
        }

        try {
            $awal = Carbon::createFromFormat('Y-m-d', $request->query('periode_awal'));
            $akhir = Carbon::createFromFormat('Y-m-d', $request->query('periode_akhir'));
        } catch (\Throwable) {
            return redirect()->route('karyawan.index', ['open_add_period' => 1])
                ->withErrors(['periode' => 'Periode tidak valid.']);
        }

        if ($awal->day !== 25 || $akhir->day !== 25 || ! $akhir->equalTo($awal->copy()->addMonthNoOverflow())) {
            return redirect()->route('karyawan.index', ['open_add_period' => 1])
                ->withErrors(['periode' => 'Periode harus dimulai tanggal 25 dan berakhir tanggal 25 bulan berikutnya.']);
        }

        [$captchaA, $captchaB] = $this->captcha($request);

        return view('karyawan.form', [
            'mode' => 'tambah',
            'karyawan' => null,
            'data' => [
                'nama' => '', 'nik' => '', 'jabatan' => '',
                'gaji_pokok' => 6500000, 'lembur' => 750000, 'pinjaman' => 500000,
                'periode_awal' => $awal->format('Y-m-d'), 'periode_akhir' => $akhir->format('Y-m-d'),
            ],
            'captchaA' => $captchaA,
            'captchaB' => $captchaB,
        ]);
    }

    public function refreshCaptcha(Request $request): RedirectResponse
    {
        $request->session()->put([
            'captcha_a' => random_int(2, 9),
            'captcha_b' => random_int(2, 9),
        ]);

        return redirect()->route('karyawan.create', [
            'periode_awal' => $request->query('periode_awal'),
            'periode_akhir' => $request->query('periode_akhir'),
        ]);
    }

    public function store(StoreKaryawanRequest $request): RedirectResponse
    {
        if (! $this->cekCaptcha($request)) {
            return back()->withErrors(['captcha_answer' => 'Captcha matematika salah.'])->withInput();
        }

        $data = $request->validated();
        unset($data['captcha_answer']);
        $data = array_merge($data, $this->hitungGaji($data));

        Karyawan::create($data);
        $request->session()->forget(['captcha_a', 'captcha_b']);

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan): View
    {
        return view('karyawan.form', [
            'mode' => 'edit', 'karyawan' => $karyawan, 'data' => $karyawan->toArray(),
            'captchaA' => null, 'captchaB' => null,
        ]);
    }

    public function update(UpdateKaryawanRequest $request, Karyawan $karyawan): RedirectResponse
    {
        $data = $request->validated();
        $karyawan->update(array_merge($data, $this->hitungGaji($data)));

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan): RedirectResponse
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function pdf(Karyawan $karyawan)
    {
        $periode = $karyawan->periode_awal && $karyawan->periode_akhir
            ? mb_strtolower($karyawan->periode_awal->translatedFormat('d M').' - '.$karyawan->periode_akhir->translatedFormat('d M Y'))
            : 'Periode belum diatur';

        $pdf = Pdf::loadView('karyawan.pdf', compact('karyawan', 'periode'))->setPaper('a4');
        $nama = preg_replace('/[^A-Za-z0-9_-]/', '-', $karyawan->nama);

        return $pdf->download('laporan-gaji-'.$nama.'.pdf');
    }

    public function whatsapp(Karyawan $karyawan): RedirectResponse
    {
        $rupiah = 'Rp '.number_format((float) $karyawan->gaji_bersih, 0, ',', '.');
        $message = "LAPORAN GAJI KARYAWAN\n"
            ."Nama: {$karyawan->nama}\n"
            ."NIK: {$karyawan->nik}\n"
            ."Jabatan: {$karyawan->jabatan}\n"
            ."Gaji Bersih: {$rupiah}";

        return redirect()->away('https://wa.me/?text='.rawurlencode($message));
    }

    private function hitungGaji(array $data): array
    {
        $penghasilan = (float) $data['gaji_pokok'] + (float) $data['lembur'];
        $potongan = (float) $data['pinjaman'];

        return [
            'total_penghasilan' => $penghasilan,
            'total_potongan' => $potongan,
            'gaji_bersih' => $penghasilan - $potongan,
        ];
    }

    private function captcha(Request $request): array
    {
        $a = $request->session()->get('captcha_a', random_int(2, 9));
        $b = $request->session()->get('captcha_b', random_int(2, 9));
        $request->session()->put(['captcha_a' => $a, 'captcha_b' => $b]);

        return [$a, $b];
    }

    private function cekCaptcha(Request $request): bool
    {
        $a = (int) $request->session()->get('captcha_a', -1);
        $b = (int) $request->session()->get('captcha_b', -1);

        return (int) $request->input('captcha_answer') === $a * $b;
    }
}
