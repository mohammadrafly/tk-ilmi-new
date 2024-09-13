<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function show()
    {
        return view('dashboard.guru.show', [
            'title' => 'Daftar Pengajar',
            'data' => Guru::all(),
        ]);
    }

    public function index()
    {
        return view('dashboard.guru.index', [
            'title' => 'Data Guru',
            'data' => Guru::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.guru.create', [
                'title' => 'Create Data Guru'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $imgPath = $request->hasFile('img')
                ? $request->file('img')->store('guru_images', 'public')
                : null;

            Guru::create([
                'nama' => $request->input('nama'),
                'no_telp' => $request->input('no_telp'),
                'alamat' => $request->input('alamat'),
                'img' => $imgPath,
            ]);

            return back()->with([
                'success' => 'Data Guru created successfully.',
                'redirect' => route('dashboard.guru.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create Data Guru. ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $guru = Guru::findOrFail($id);
            return view('dashboard.guru.edit', [
                'title' => 'Edit Data Guru',
                'guru' => $guru
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $guru = Guru::findOrFail($id);
            $guru->nama = $request->input('nama');
            $guru->no_telp = $request->input('no_telp');
            $guru->alamat = $request->input('alamat');

            if ($request->hasFile('img')) {
                if ($guru->img) {
                    Storage::disk('public')->delete($guru->img);
                }
                $guru->img = $request->file('img')->store('guru_images', 'public');
            }

            $guru->save();

            return back()->with([
                'success' => 'Data Guru updated successfully.',
                'redirect' => route('dashboard.guru.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Data Guru.']);
        }
    }

    public function delete($id)
    {
        try {
            $guru = Guru::findOrFail($id);

            if ($guru->img) {
                Storage::disk('public')->delete($guru->img);
            }

            $guru->delete();

            return back()->with([
                'success' => 'Data Guru deleted successfully.',
                'redirect' => route('dashboard.guru.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete Data Guru.']);
        }
    }
}
