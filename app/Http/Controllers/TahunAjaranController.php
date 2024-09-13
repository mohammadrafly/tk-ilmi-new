<?php

namespace App\Http\Controllers;

use App\Models\ProgramSemester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TahunAjaranController extends Controller
{
    public function index()
    {
        return view('dashboard.tahun_ajaran.index', [
            'title' => 'Data Tahun Ajaran',
            'data' => TahunAjaran::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.tahun_ajaran.create', [
                'title' => 'Create Data Tahun Ajaran'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'tahunawal' => 'required|string|max:4',
            'tahunakhir' => 'required|string|max:4|after_or_equal:tahunawal',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            TahunAjaran::create([
                'tahunawal' => $request->input('tahunawal'),
                'tahunakhir' => $request->input('tahunakhir'),
            ]);

            return back()->with([
                'success' => 'Data Tahun Ajaran created successfully.',
                'redirect' => route('dashboard.tahunajaran.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create Data Tahun Ajaran.' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('dashboard.tahun_ajaran.edit', [
            'title' => 'Edit Data Tahun Ajaran',
            'tahunAjaran' => $tahunAjaran
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $tahunAjaran = TahunAjaran::findOrFail($id);
            return view('dashboard.tahun_ajaran.edit', [
                'title' => 'Edit Data Tahun Ajaran',
                'tahunAjaran' => $tahunAjaran
            ]);
        }

        $validator = Validator::make($request->all(), [
            'tahunawal' => 'required|string|max:4',
            'tahunakhir' => 'required|string|max:4|after_or_equal:tahunawal',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $tahunAjaran = TahunAjaran::findOrFail($id);
            $tahunAjaran->tahunawal = $request->input('tahunawal');
            $tahunAjaran->tahunakhir = $request->input('tahunakhir');
            $tahunAjaran->save();

            return back()->with([
                'success' => 'Data Tahun Ajaran updated successfully.',
                'redirect' => route('dashboard.tahunajaran.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Data Tahun Ajaran.']);
        }
    }

    public function delete($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        if ($tahunAjaran->programSemesters()->exists()) {
            return back()->withErrors([
                'error' => 'Cannot delete Tahun Ajaran as it is being used by one or more Program Semesters.'
            ]);
        }

        try {
            $tahunAjaran->delete();

            return back()->with([
                'success' => 'Data Tahun Ajaran deleted successfully.',
                'redirect' => route('dashboard.tahunajaran.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete Data Tahun Ajaran.']);
        }
    }
}
