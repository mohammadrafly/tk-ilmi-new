<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.users.index', [
            'title' => 'Data User',
            'data' => User::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.users.create', [
                'title' => 'Create User'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'required|string|in:admin,guru,siswa',
            'jk' => 'required|string|in:male,female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('fotos', 'public') : null;

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'foto' => $fotoPath,
                'role' => $request->input('role'),
                'jk' => $request->input('jk'),
            ]);

            return back()->with([
                'success' => 'User created successfully.',
                'redirect' => route('dashboard.user.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create user.']);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $user = User::findOrFail($id);
            return view('dashboard.users.edit', [
                'title' => 'Update User',
                'user' => $user,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'required|string|in:admin,guru,siswa',
            'jk' => 'required|string|in:male,female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->role = $request->input('role');
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
                'redirect' => route('dashboard.user.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update user.']);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->delete();

            return back()->with([
                'success' => 'User deleted successfully.',
                'redirect' => route('dashboard.user.index')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete user.']);
        }
    }
}
