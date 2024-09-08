<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\Agama;
use App\Models\User;

class SiswaController extends Controller
{
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
            'foto_siswa' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_akte_kelahiran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_orang_tua' => 'required|string|max:255',
            'alamat_orang_tua' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $fotoSiswaPath = $request->hasFile('foto_siswa') ? $request->file('foto_siswa')->store('foto_siswa', 'public') : null;
            $fotoAkteKelahiranPath = $request->hasFile('foto_akte_kelahiran') ? $request->file('foto_akte_kelahiran')->store('foto_akte_kelahiran', 'public') : null;

            Siswa::create([
                'user_id' => $request->input('user_id'),
                'alamat' => $request->input('alamat'),
                'tempat_lahir' => $request->input('tempat_lahir'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'agama_id' => $request->input('agama_id'),
                'foto_siswa' => $fotoSiswaPath,
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
            'foto_siswa' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_akte_kelahiran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

            if ($request->hasFile('foto_siswa')) {
                if ($siswa->foto_siswa) {
                    Storage::disk('public')->delete($siswa->foto_siswa);
                }
                $siswa->foto_siswa = $request->file('foto_siswa')->store('foto_siswa', 'public');
            }

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
            if ($siswa->foto_siswa) {
                Storage::disk('public')->delete($siswa->foto_siswa);
            }
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
}
