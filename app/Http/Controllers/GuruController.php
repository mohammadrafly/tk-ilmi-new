<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index()
    {
        return view('dashboard.guru.index', [
            'title' => 'Data Guru',
            'data' => Guru::with('user')->get()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.guru.create', [
                'title' => 'Create Guru',
                'users' => User::where('role', 'guru')->get()
            ]);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|integer|min:18|unique:guru',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Guru::create([
                'user_id' => $request->input('user_id'),
                'nip' => $request->input('nip'),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('no_telp'),
            ]);

            return back()->with([
                'success' => 'Guru created successfully.',
                'redirect' => route('dashboard.guru.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create guru.']);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $guru = Guru::findOrFail($id);
            return view('dashboard.guru.edit', [
                'title' => 'Update Guru',
                'guru' => $guru,
                'users' => User::where('role', 'guru')->get()
            ]);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|integer|min:18|unique:guru,nip,' . $id,
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $guru = Guru::findOrFail($id);
            $guru->user_id = $request->input('user_id');
            $guru->nip = $request->input('nip');
            $guru->alamat = $request->input('alamat');
            $guru->no_telp = $request->input('no_telp');

            $guru->save();

            return back()->with([
                'success' => 'Guru updated successfully.',
                'redirect' => route('dashboard.guru.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update guru.']);
        }
    }

    public function delete($id)
    {
        try {
            $guru = Guru::findOrFail($id);
            $guru->delete();

            return back()->with([
                'success' => 'Guru deleted successfully.',
                'redirect' => route('dashboard.guru.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete guru.']);
        }
    }
}
