<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgamaController extends Controller
{
    public function index()
    {
        return view('dashboard.agama.index', [
            'title' => 'Data Agama',
            'data' => Agama::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.agama.create', [
                'title' => 'Create Agama',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Agama::create([
                'nama' => $request->input('nama'),
            ]);

            return back()->with([
                'success' => 'Agama created successfully.',
                'redirect' => route('dashboard.agama.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create agama.']);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $agama = Agama::findOrFail($id);
            return view('dashboard.agama.edit', [
                'title' => 'Update Agama',
                'agama' => $agama,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $agama = Agama::findOrFail($id);
            $agama->nama = $request->input('nama');

            $agama->save();

            return back()->with([
                'success' => 'Agama updated successfully.',
                'redirect' => route('dashboard.agama.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update agama.']);
        }
    }

    public function delete($id)
    {
        try {
            $agama = Agama::findOrFail($id);
            $agama->delete();

            return back()->with([
                'success' => 'Agama deleted successfully.',
                'redirect' => route('dashboard.agama.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete agama.']);
        }
    }
}
