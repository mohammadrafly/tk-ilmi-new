<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriTransaksiController extends Controller
{
    public function index()
    {
        return view('dashboard.kategori_transaksi.index', [
            'title' => 'Kategori Transaksi',
            'data' => KategoriTransaksi::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.kategori_transaksi.create', [
                'title' => 'Create Kategori Transaksi'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'interval' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            KategoriTransaksi::create([
                'nama' => $request->input('nama'),
                'harga' => $request->input('harga'),
                'interval' => $request->input('interval'),
            ]);

            return back()->with([
                'success' => 'Kategori Transaksi created successfully.',
                'redirect' => route('dashboard.kategori.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create Kategori Transaksi.' . $e]);
        }
    }

    public function edit($id)
    {
        $kategoriTransaksi = KategoriTransaksi::findOrFail($id);
        return view('dashboard.kategori_transaksi.edit', [
            'title' => 'Edit Kategori Transaksi',
            'kategoriTransaksi' => $kategoriTransaksi
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $kategoriTransaksi = KategoriTransaksi::findOrFail($id);
            return view('dashboard.kategori_transaksi.edit', [
                'title' => 'Edit Kategori Transaksi',
                'kategoriTransaksi' => $kategoriTransaksi
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'interval' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kategoriTransaksi = KategoriTransaksi::findOrFail($id);
            $kategoriTransaksi->nama = $request->input('nama');
            $kategoriTransaksi->harga = $request->input('harga');
            $kategoriTransaksi->interval = $request->input('interval');
            $kategoriTransaksi->save();

            return back()->with([
                'success' => 'Kategori Transaksi updated successfully.',
                'redirect' => route('dashboard.kategori.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Kategori Transaksi.']);
        }
    }

    public function delete($id)
    {
        try {
            $kategoriTransaksi = KategoriTransaksi::findOrFail($id);
            $kategoriTransaksi->delete();

            return back()->with([
                'success' => 'Kategori Transaksi deleted successfully.',
                'redirect' => route('dashboard.kategori.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete Kategori Transaksi.']);
        }
    }
}
