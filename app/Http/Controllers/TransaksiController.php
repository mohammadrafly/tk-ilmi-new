<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\ListTransaksi;
use App\Models\ListCicilTransaksi;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    public function paymentPendaftaran($kode)
    {
        $checkIfExist = Transaksi::where('kode', $kode)->first();
        if (!$checkIfExist) {
            return redirect()->route('dashboard.index')->with([
                'success' => 'Transaksi not found.',
                'redirect' => route('dashboard.index')
            ]);;
        }

        return view('dashboard.pendaftaran.payment', [
            'title' => 'Bayar Pendaftaran',
            'transaksi' => Transaksi::where('kode', $kode)->first(),
            'listTransaksi' => ListTransaksi::where('kode', $kode)->get(),
            'totalHarga' => ListTransaksi::where('kode', $kode)->sum('harga'),
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $fileName = 'transaksi_' . $request->from_date . '_to_' . $request->to_date . '.xlsx';

        return Excel::download(new TransaksiExport($request->from_date, $request->to_date), $fileName);
    }

    public function index()
    {
        return view('dashboard.transaksi.index', [
            'title' => 'Data Transaksi',
            'data' => Auth::user()->role !== 'admin'
                ? Transaksi::with('user')->where('user_id', Auth::user()->id)->get()
                : Transaksi::with('user')->get()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.transaksi.create', [
                'title' => 'Menu Pembayaran',
                'users' => User::all(),
                'kategori' => KategoriTransaksi::where('nama', '!=', 'Pendaftaran')->get(),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'metode' => 'required|in:cash,online',
            'jenis' => 'required|in:penuh,cicil',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategori_transaksi,id',
            'bulan' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kode = Str::uuid()->toString();
            $kategoriIds = $request->input('kategori_ids', []);
            $totalHarga = 0;

            foreach ($kategoriIds as $kategoriId) {
                $kategori = KategoriTransaksi::find($kategoriId);
                $namaKategori = $kategori->nama;

                if ($kategori) {
                    $startOfMonth = Carbon::now()->startOfMonth();

                    $interval = (int) $kategori->interval;

                    $intervalEnd = $startOfMonth->copy()->addDays($interval);

                    $existingTransaction = ListTransaksi::with('transaksi')->where('kategori_id', $kategoriId)
                        ->whereBetween('created_at', [$startOfMonth, $intervalEnd])
                        ->whereHas('transaksi', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        })
                        ->first();

                    if ($existingTransaction != null) {
                        if ($existingTransaction->transaksi->status !== '2') {
                            return redirect()->back()->withErrors(['kategori_ids' => 'Pembayaran untuk kategori ' . $namaKategori . ' belum lunas. Silakan lunasi tagihan sebelumnya terlebih dahulu.']);
                        }

                        $nextPaymentDate = $intervalEnd->format('d F Y');
                        return redirect()->back()->withErrors(['kategori_ids' => 'Pembayaran untuk kategori ' . $namaKategori . ' telah diproses sebelumnya. Silakan lakukan pembayaran berikutnya pada ' . $nextPaymentDate . '.']);
                    }

                    ListTransaksi::create([
                        'kode' => $kode,
                        'kategori_id' => $kategoriId,
                        'harga' => $kategori->harga,
                    ]);

                    $totalHarga += $kategori->harga;
                }
            }

            $transaksi = Transaksi::create([
                'kode' => $kode,
                'user_id' => Auth::user()->id,
                'keterangan' => '-',
                'metode' => $request->input('metode'),
                'jenis' => $request->input('jenis'),
                'status' => $request->input('jenis') === 'cicil' ? '1' : '0',
            ]);

            if ($transaksi->jenis === 'cicil') {
                $bulan = $request->input('bulan');
                $cicilan = $totalHarga / $bulan;
                $startDate = Carbon::now();

                foreach (range(1, $bulan) as $i) {
                    ListCicilTransaksi::create([
                        'kode' => $transaksi->kode,
                        'bulan' => $i,
                        'cicilan' => $cicilan,
                        'expired' => $startDate->addMonth()->format('Y-m-d'),
                        'status' => $request->input('status_cicilan', 'belum_lunas'),
                    ]);
                }
            }

            return back()->with([
                'success' => 'Pemabayaran berhasil dibuat.',
                'redirect' => route('dashboard.transaksi.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to buat transaksi. ' . $e->getMessage()]);
        }
    }

    public function show(Request $request, $kode)
    {
        if ($request->isMethod('GET')) {
            $transaksi = Transaksi::with('user')->where('kode', $kode)->firstOrFail();
            $listTransaksi = ListTransaksi::with('kategori')->where('kode', $kode)->get();
            $listCicilTransaksi = ListCicilTransaksi::where('kode', $kode)->get();

            $totalHarga = $listTransaksi->sum('harga');

            return view('dashboard.transaksi.edit', [
                'transaksi' => $transaksi,
                'listTransaksi' => $listTransaksi,
                'listCicilTransaksi' => $listCicilTransaksi,
                'totalHarga' => $totalHarga,
                'title' => 'Detail Transaksi'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            ListTransaksi::where('kode', $transaksi->kode)->delete();
            ListCicilTransaksi::where('kode', $transaksi->kode)->delete();

            $transaksi->delete();

            return back()->with([
                'success' => 'Transaksi deleted successfully.',
                'redirect' => route('dashboard.transaksi.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete transaksi.']);
        }
    }

    public function checkPayment(Request $request)
    {
        if ($request->isMethod('POST')) {
            $kode = $request->input('kode');
            $payments = Transaksi::with('user')->where('kode', $kode)->get();

            if ($payments->isEmpty()) {
                return view('dashboard.transaksi.approvepayment', [
                    'title' => 'Cari Transaksi',
                    'kode' => $kode,
                    'error' => 'No transactions found for the code ' . $kode,
                ]);
            }

            return view('dashboard.transaksi.approvepayment', [
                'title' => 'Cari Transaksi',
                'payments' => $payments,
            ]);
        }

        return view('dashboard.transaksi.approvepayment', [
            'title' => 'Cari Transaksi',
        ]);
    }

    public function checkPaymentDetail($kode)
    {
        $transaksi = Transaksi::with('user')->where('kode', $kode)->firstOrFail();
        $listTransaksi = ListTransaksi::with('kategori')->where('kode', $kode)->get();
        $listCicilTransaksi = ListCicilTransaksi::where('kode', $kode)->get();

        $totalHarga = $listTransaksi->sum('harga');

        return view('dashboard.transaksi.details', [
            'transaksi' => $transaksi,
            'listTransaksi' => $listTransaksi,
            'listCicilTransaksi' => $listCicilTransaksi,
            'totalHarga' => $totalHarga,
            'title' => 'Detail Transaksi'
        ]);
    }

    public function approvePaymentPenuh($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->jenis !== 'penuh') {
            return redirect()->back()->with('error', 'Invalid jenis transaksi.');
        }

        $transaksi->status = '2';
        $transaksi->save();

        if ($transaksi->kategoriTransaksi[0]->nama === 'Pendaftaran') {
            $siswa = Siswa::where('user_id', $transaksi->user_id)->first();
            $siswa->status = 'active';
            $siswa->save();
        }

        return redirect()->route('dashboard.transaksi.check.detail', $transaksi->kode)
                         ->with('success', 'Full cash payment approved successfully.');
    }

    public function approvePaymentCicil($id)
    {
        $cicil = ListCicilTransaksi::findOrFail($id);

        if ($cicil->status === 'lunas') {
            return redirect()->back()->with('error', 'Transaksi already lunas.');
        }

        $cicil->status = 'lunas';
        $cicil->save();

        $transaksi = Transaksi::where('kode', $cicil->kode)->first();
        $allCicilLunas = ListCicilTransaksi::where('kode', $transaksi->kode)
                                          ->where('status', '!=', 'lunas')
                                          ->count() === 0;

        if ($allCicilLunas) {
            $transaksi->status = '2';
            $transaksi->save();
        }

        return redirect()->route('dashboard.transaksi.check.detail', $cicil->kode)
                         ->with('success', 'Cicil payment approved successfully.');
    }

    public function paymentOnlinePenuh($kode)
    {
        $data = Transaksi::with('user', 'siswa')->where('kode', $kode)->first();

        $listItem = ListTransaksi::with('kategori')->where('kode', $kode)->get();
        $totalHarga = $listItem->sum('harga');

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $itemDetails = [];
        $isPendaftaran = false;
        $finish = null;

        foreach ($listItem as $item) {
            $itemDetails[] = [
                'id' => $item->kategori->id,
                'price' => $item->harga,
                'quantity' => 1,
                'name' => $item->kategori->nama,
            ];

            if ($item->kategori->nama === 'Pendaftaran') {
                $isPendaftaran = true;
            }
        }


        if ($isPendaftaran) {
            $finish = route('api.callback.pendaftaran', $data->kode);
        } else {
            $finish = route('api.callback.online.penuh', $data->kode);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $data->kode,
                'gross_amount' => $totalHarga,
            ],
            'customer_details' => [
                'first_name' => $data->user->name,
                'email' => $data->user->email,
                'billing_address' => [
                    'address' => $data->siswa->alamat,
                ],
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => $finish,
            ],
        ];

        return response()->json(Snap::getSnapToken($params));
    }

    public function callbackSuccessPaymentOnlinePenuh($kode)
    {
        $data = Transaksi::where('kode', $kode)->first();
        $data->update(['status' => '2']);

        return redirect()->route('dashboard.index')->with('success', 'Pembayaran Berhasil!');
    }

    public function callbackSuccessPaymentOnlinePendaftaran($kode)
    {
        $data = Transaksi::where('kode', $kode)->first();
        $data->update(['status' => '2']);

        $siswa = Siswa::where('user_id', $data->user_id)->first();
        $siswa->update(['status' => 'active']);

        return redirect()->route('dashboard.index')->with('success', 'Pembayaran Berhasil!');
    }

    public function paymentOnlineCicil($id)
    {
        $listCicilTransaksi = ListCicilTransaksi::where('id', $id)->first();
        $data = Transaksi::with('user', 'siswa')->where('kode', $listCicilTransaksi->kode)->first();

        $totalHarga = intval($listCicilTransaksi->cicilan);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $bulan = $listCicilTransaksi->bulan === '1' ? 'Bulan Pertama' : 'Bulan Kedua';

        $params = [
            'transaction_details' => [
                'order_id' => 'INSTALLMENT-'. $listCicilTransaksi->id . time() ,
                'gross_amount' => $totalHarga,
            ],
            'customer_details' => [
                'first_name' => $data->user->name,
                'email' => $data->user->email,
                'billing_address' => [
                    'address' => $data->siswa->alamat,
                ],
            ],
            'item_details' => [
                [
                    'id' => $listCicilTransaksi->id,
                    'price' => $totalHarga,
                    'quantity' => 1,
                    'name' => $bulan,
                ],
            ],
            'callbacks' => [
                'finish' => route('api.callback.online.penuh', $data->kode),
            ],
        ];

        return response()->json(Snap::getSnapToken($params));
    }

    public function callbackSuccessPaymentOnlineCicil($id)
    {
        $cicil = ListCicilTransaksi::findOrFail($id);

        if ($cicil->status === 'lunas') {
            return redirect()->back()->with('error', 'Transaksi already lunas.');
        }

        $cicil->status = 'lunas';
        $cicil->save();

        $transaksi = Transaksi::where('kode', $cicil->kode)->first();
        $allCicilLunas = ListCicilTransaksi::where('kode', $transaksi->kode)
                                          ->where('status', '!=', 'lunas')
                                          ->count() === 0;

        if ($allCicilLunas) {
            $transaksi->status = '2';
            $transaksi->save();
        }

        return redirect()->route('dashboard.transaksi.check.detail', $cicil->kode)->with('success', 'Pembayaran Berhasil!');
    }
}
