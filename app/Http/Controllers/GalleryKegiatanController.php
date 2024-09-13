<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\GalleryKegiatan;

class GalleryKegiatanController extends Controller
{
    public function show()
    {
        return view('dashboard.gallery_kegiatan.show', [
            'title' => 'Daftar Kegiatan',
            'data' => GalleryKegiatan::all(),
        ]);
    }

    public function index()
    {
        return view('dashboard.gallery_kegiatan.index', [
            'title' => 'Data Kegiatan',
            'data' => GalleryKegiatan::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.gallery_kegiatan.create', [
                'title' => 'Create Data Kegiatan'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $imgPath = $request->hasFile('img')
                ? $request->file('img')->store('gallery_images', 'public')
                : null;

            GalleryKegiatan::create([
                'title' => $request->input('title'),
                'tanggal' => $request->input('tanggal'),
                'img' => $imgPath,
            ]);

            return back()->with([
                'success' => 'Data Kegiatan created successfully.',
                'redirect' => route('dashboard.gallerykegiatan.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create Data Kegiatan. ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $kegiatan = GalleryKegiatan::findOrFail($id);
            return view('dashboard.gallery_kegiatan.edit', [
                'title' => 'Edit Data Kegiatan',
                'kegiatan' => $kegiatan
            ]);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kegiatan = GalleryKegiatan::findOrFail($id);
            $kegiatan->title = $request->input('title');
            $kegiatan->tanggal = $request->input('tanggal');

            if ($request->hasFile('img')) {
                if ($kegiatan->img) {
                    Storage::disk('public')->delete($kegiatan->img);
                }
                $kegiatan->img = $request->file('img')->store('gallery_images', 'public');
            }

            $kegiatan->save();

            return back()->with([
                'success' => 'Data Kegiatan updated successfully.',
                'redirect' => route('dashboard.gallerykegiatan.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update Data Kegiatan.']);
        }
    }

    public function delete($id)
    {
        try {
            $kegiatan = GalleryKegiatan::findOrFail($id);

            if ($kegiatan->img) {
                Storage::disk('public')->delete($kegiatan->img);
            }

            $kegiatan->delete();

            return back()->with([
                'success' => 'Data Kegiatan deleted successfully.',
                'redirect' => route('dashboard.gallerykegiatan.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete Data Kegiatan.']);
        }
    }
}
