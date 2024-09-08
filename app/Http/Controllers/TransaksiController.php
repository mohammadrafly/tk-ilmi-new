<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\ListTransaksi;
use App\Models\ListCicilTransaksi;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('dashboard.transaksi.index', [
            'title' => 'Data Transaksi',
            'data' => Transaksi::with('user')->get()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.transaksi.create', [
                'title' => 'Create Transaksi',
                'users' => User::all(),
                'kategori' => KategoriTransaksi::all(),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'metode' => 'required|in:cash,transfer',
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

            $transaksi = Transaksi::create([
                'kode' => $kode,
                'user_id' => $request->input('user_id'),
                'keterangan' => '-',
                'metode' => $request->input('metode'),
                'jenis' => $request->input('jenis'),
                'status' => '0',
            ]);

            $kategoriIds = $request->input('kategori_ids', []);

            $totalHarga = 0;
            foreach ($kategoriIds as $kategoriId) {
                $kategori = KategoriTransaksi::find($kategoriId);
                if ($kategori) {
                    ListTransaksi::create([
                        'kode' => $transaksi->kode,
                        'kategori_id' => $kategoriId,
                        'harga' => $kategori->harga,
                    ]);
                    $totalHarga += $kategori->harga;
                }
            }

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
                'success' => 'Transaksi created successfully.',
                'redirect' => route('dashboard.transaksi.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create transaksi.'. $e]);
        }
    }

    public function update(Request $request, $kode)
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

        $transaksi = Transaksi::where('kode', $kode)->get();

        $validator = Validator::make($request->all(), [
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|integer|in:0,1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $transaksi->update([
                'status' => $request->input('status'),
            ]);

            return back()->with([
                'success' => 'Transaksi status updated successfully.',
                'redirect' => route('dashboard.transaksi.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update transaksi status.']);
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

    public function transferPaymentTransaksi(Request $request, $transaksiId)
    {
        if ($request->isMethod('GET')) {
            $transaksi = Transaksi::findOrFail($transaksiId);
            return view('dashboard.transaksi.payment', [
                'title' => 'Transfer Payment',
                'transaksi' => $transaksi
            ]);
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048',
            'status' => '1'
        ]);

        $transaksi = Transaksi::findOrFail($transaksiId);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti_pembayarans', $filename, 'public');

            $transaksi->bukti_pembayaran = $filename;
            $transaksi->save();
        }

        return redirect()->route('dashboard.transaksi.index')->with('success', 'Payment proof uploaded successfully!');
    }

    public function transferPaymentCicil(Request $request, $cicilId)
    {
        if ($request->isMethod('GET')) {
            $transaksi = ListCicilTransaksi::findOrFail($cicilId);
            return view('dashboard.transaksi.paymentcicil', [
                'title' => 'Transfer Payment',
                'transaksi' => $transaksi
            ]);
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048',
        ]);

        $transaksi = ListCicilTransaksi::findOrFail($cicilId);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti_pembayarans', $filename, 'public');

            $transaksi->bukti_pembayaran = $filename;
            $transaksi->save();
        }

        return redirect()->route('dashboard.transaksi.index')->with('success', 'Payment proof uploaded successfully!');
    }
}
