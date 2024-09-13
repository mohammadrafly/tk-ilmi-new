<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProgramSemester;
use App\Models\TahunAjaran;

class ProgramSemesterController extends Controller
{
    public function show()
    {
        return view('dashboard.programsemester.show', [
            'title' => 'Daftar Program Semester',
            'data' => ProgramSemester::all(),
        ]);
    }

    public function index()
    {
        return view('dashboard.program_semester.index', [
            'title' => 'Data Program Semester',
            'data' => ProgramSemester::with('tahunajaran')->get()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.program_semester.create', [
                'title' => 'Create Data Program Semester',
                'tahunajaran' => TahunAjaran::all()
            ]);
        }

        $validator = Validator::make($request->all(), [
            'tahun_ajaran' => 'required|string|max:255',
            'semester' => 'required|string|in:1,2',
            'bulan' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'minggu1' => 'required|string|max:255',
            'minggu2' => 'required|string|max:255',
            'minggu3' => 'required|string|max:255',
            'minggu4' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            ProgramSemester::create([
                'tahun_ajaran' => $request->input('tahun_ajaran'),
                'bulan' => $request->input('bulan'),
                'topik' => $request->input('topik'),
                'minggu1' => $request->input('minggu1'),
                'minggu2' => $request->input('minggu2'),
                'minggu3' => $request->input('minggu3'),
                'minggu4' => $request->input('minggu4'),
                'semester' => $request->input('semester'),
            ]);

            return back()->with([
                'success' => 'Data Program Semester created successfully.',
                'redirect' => route('dashboard.programsemester.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create Data Program Semester. ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $programSemester = ProgramSemester::findOrFail($id);
            return view('dashboard.program_semester.edit', [
                'title' => 'Edit Data Program Semester',
                'programSemester' => $programSemester,
                'tahunajaran' => TahunAjaran::all()
            ]);
        }

        $validator = Validator::make($request->all(), [
            'tahun_ajaran' => 'required|string|max:255',
            'semester' => 'required|string|in:1,2',
            'bulan' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'minggu1' => 'required|string|max:255',
            'minggu2' => 'required|string|max:255',
            'minggu3' => 'required|string|max:255',
            'minggu4' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $programSemester = ProgramSemester::findOrFail($id);
            $programSemester->tahun_ajaran = $request->input('tahun_ajaran');
            $programSemester->bulan = $request->input('bulan');
            $programSemester->topik = $request->input('topik');
            $programSemester->minggu1 = $request->input('minggu1');
            $programSemester->minggu2 = $request->input('minggu2');
            $programSemester->minggu3 = $request->input('minggu3');
            $programSemester->minggu4 = $request->input('minggu4');
            $programSemester->semester = $request->input('semester');

            $programSemester->save();

            return back()->with([
                'success' => 'Data Program Semester updated successfully.',
                'redirect' => route('dashboard.programsemester.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Data Program Semester.']);
        }
    }

    public function delete($id)
    {
        try {
            $programSemester = ProgramSemester::findOrFail($id);
            $programSemester->delete();

            return back()->with([
                'success' => 'Data Program Semester deleted successfully.',
                'redirect' => route('dashboard.programsemester.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete Data Program Semester.']);
        }
    }
}
