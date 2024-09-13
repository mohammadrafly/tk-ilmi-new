<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\Agama;
use App\Models\KategoriTransaksi;
use App\Models\ListTransaksi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function pendaftaranSiswa(Request $request)
    {
        $id = Auth::user()->id;
        $siswa = Siswa::where('user_id', $id)->first();

        if ($request->isMethod('GET')) {
            return view('dashboard.pendaftaran.index', [
                'title' => 'Lengkapi Pendaftaran',
                'agamas' => Agama::all(),
                'siswa' => $siswa
            ]);
        }

        $request->validate([
            'alamat' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama_id' => 'required|exists:agama,id',
            'foto_akte_kelahiran' => 'required|file|mimes:pdf|max:2048',
            'nama_orang_tua' => 'required|string|max:255',
            'alamat_orang_tua' => 'required|string|max:255',
        ]);

        $siswa = Siswa::where('user_id', $id)->firstOrFail();
        $siswa->alamat = $request->input('alamat');
        $siswa->tempat_lahir = $request->input('tempat_lahir');
        $siswa->tanggal_lahir = $request->input('tanggal_lahir');
        $siswa->agama_id = $request->input('agama_id');
        $siswa->nama_orang_tua = $request->input('nama_orang_tua');
        $siswa->alamat_orang_tua = $request->input('alamat_orang_tua');

        if ($request->hasFile('foto_akte_kelahiran')) {
            $file = $request->file('foto_akte_kelahiran');
            $path = $file->store('public/foto_akte_kelahiran');
            $siswa->foto_akte_kelahiran = $path;
        }

        $siswa->save();

        $pendaftaran = KategoriTransaksi::where('nama', 'Pendaftaran')->first();

        $kode = Str::uuid()->toString();

        if ($pendaftaran) {
            ListTransaksi::create([
                'kode' => $kode,
                'kategori_id' => $pendaftaran->id,
                'harga' => $pendaftaran->harga
            ]);

            $transaksi = Transaksi::create([
                'kode' => $kode,
                'user_id' => Auth::user()->id,
                'keterangan' => '-',
                'metode' => 'cash',
                'jenis' => 'penuh',
                'status' => '0',
            ]);
        } else {
            return redirect()->route('dashboard.pendaftaran.index')->with([
                'error' => 'Gagal melengkapi data. Silahkan hubungi administrasi.',
            ]);
        }

        return redirect()->route('dashboard.pendaftaran.payment', $transaksi->kode)->with([
            'success' => 'Data berhasil dilengkapi. Please proceed to payment.',
        ]);
    }

    public function index()
    {
        return view('dashboard.siswa.index', [
            'title' => 'Data Siswa',
            'data' => Siswa::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.siswa.create', [
                'title' => 'Create Siswa',
                'agamas' => Agama::all(),
                'users' => User::where('role', 'siswa')->get()
            ]);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'alamat' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama_id' => 'required|exists:agama,id',
            'foto_akte_kelahiran' => 'nullable|file|mimes:pdf|max:2048',
            'nama_orang_tua' => 'required|string|max:255',
            'alamat_orang_tua' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $fotoAkteKelahiranPath = $request->hasFile('foto_akte_kelahiran') ? $request->file('foto_akte_kelahiran')->store('foto_akte_kelahirans', 'public') : null;

            Siswa::create([
                'user_id' => $request->input('user_id'),
                'alamat' => $request->input('alamat'),
                'tempat_lahir' => $request->input('tempat_lahir'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'agama_id' => $request->input('agama_id'),
                'foto_akte_kelahiran' => $fotoAkteKelahiranPath,
                'nama_orang_tua' => $request->input('nama_orang_tua'),
                'alamat_orang_tua' => $request->input('alamat_orang_tua'),
            ]);

            return back()->with([
                'success' => 'Siswa created successfully.',
                'redirect' => route('dashboard.siswa.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create siswa.']);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $siswa = Siswa::findOrFail($id);
            return view('dashboard.siswa.edit', [
                'title' => 'Update Siswa',
                'siswa' => $siswa,
                'agamas' => Agama::all(),
                'users' => User::where('role', 'siswa')->get()
            ]);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'alamat' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama_id' => 'required|exists:agama,id',
            'foto_akte_kelahiran' => 'nullable|mimes:pdf|max:2048',
            'nama_orang_tua' => 'required|string|max:255',
            'alamat_orang_tua' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->user_id = $request->input('user_id');
            $siswa->alamat = $request->input('alamat');
            $siswa->tempat_lahir = $request->input('tempat_lahir');
            $siswa->tanggal_lahir = $request->input('tanggal_lahir');
            $siswa->agama_id = $request->input('agama_id');
            $siswa->nama_orang_tua = $request->input('nama_orang_tua');
            $siswa->alamat_orang_tua = $request->input('alamat_orang_tua');

            if ($request->hasFile('foto_akte_kelahiran')) {
                if ($siswa->foto_akte_kelahiran) {
                    Storage::disk('public')->delete($siswa->foto_akte_kelahiran);
                }
                $siswa->foto_akte_kelahiran = $request->file('foto_akte_kelahiran')->store('foto_akte_kelahiran', 'public');
            }

            $siswa->save();

            return back()->with([
                'success' => 'Siswa updated successfully.',
                'redirect' => route('dashboard.siswa.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update siswa.']);
        }
    }

    public function delete($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            if ($siswa->foto_akte_kelahiran) {
                Storage::disk('public')->delete($siswa->foto_akte_kelahiran);
            }
            $siswa->delete();

            return back()->with([
                'success' => 'Siswa deleted successfully.',
                'redirect' => route('dashboard.siswa.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete siswa.']);
        }
    }

    public function viewCertificate($id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto_akte_kelahiran) {
            $path = Storage::url($siswa->foto_akte_kelahiran);
            return redirect($path);
        }

        return redirect()->back()->with('error', 'Birth certificate not found');
    }
}
