<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        return view('dashboard.role.index', [
            'title' => 'List Role',
            'data' => Role::with('permissions')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('dashboard.role.create', [
                'title' => 'Buat Role',
                'permissions' => Permission::all(),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,slug',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $role = Role::create(['name' => $request->name]);

            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('slug', $request->permissions)->get();
                $role->permissions()->sync($permissions);
            }

            return redirect()->route('dashboard.roles.index')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create data.']);
        }
    }

    public function assignPermissionsToRole(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,slug',
        ]);

        $permissions = Permission::whereIn('slug', $request->permissions)->get();
        $role->permissions()->sync($permissions);

        return response()->json(['message' => 'Permissions assigned successfully', 'role' => $role->load('permissions')]);
    }

}
