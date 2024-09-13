<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $validator = Validator::make($request->all(), [
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

                $siswa->foto_akte_kelahiran = $request->file('foto_akte_kelahiran')->store('foto_akte_kelahirans', 'public');
            }

            $siswa->save();

            return redirect()->back()->with('success', 'Siswa details updated successfully');

            return back()->with([
                'success' => 'User updated successfully.',
                'redirect' => route('dashboard.update.profile', $siswa->user->email)
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update profile.']);
        }
    }


    public function updateProfile(Request $request, $email)
    {
        $user = User::with('siswa')->where('email', $email)->first();
        if ($request->isMethod('GET')) {
            return view('dashboard.profile.index', [
                'title' => 'Dashboard',
                'data' => $user,
                'agama' => Agama::all(),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jk' => 'required|string|in:male,female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->jk = $request->input('jk');

            if ($request->hasFile('foto')) {
                if ($user->foto) {
                    Storage::disk('public')->delete($user->foto);
                }
                $user->foto = $request->file('foto')->store('fotos', 'public');
            }

            $user->save();

            return back()->with([
                'success' => 'User updated successfully.',
                'redirect' => route('dashboard.update.profile', $user->email)
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update profile.']);
        }
    }

    public function updatePassword(Request $request, $email)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $email)->first();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        try {
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return back()->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update password.']);
        }
    }
}
