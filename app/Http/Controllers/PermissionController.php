<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        return view('dashboard.permission.index', [
            'title' => 'List Permission',
            'data' => Permission::with('roles')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('GET')) {
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map('current', $tables);

            $filteredTables = array_filter($tableNames, function ($table) {
                return !in_array($table, ['migrations', 'password_resets', 'failed_jobs', 'cache', 'cache_locks', 'job_batches', 'jobs', 'password_reset_tokens', 'personal_access_tokens', '']);
            });

            return view('dashboard.permission.create', [
                'title' => 'Buat Permission',
                'tables' => $filteredTables,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'action' => 'required|string',
            'resource' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $slug = "{$request->action}-{$request->resource}";

        try {
            Permission::create([
                'action' => $request->action,
                'resource' => $request->resource,
                'slug' => $slug,
            ]);

            return redirect()->route('dashboard.permission.index')->with('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create data.']);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map('current', $tables);

            $filteredTables = array_filter($tableNames, function ($table) {
                return !in_array($table, ['migrations', 'password_resets', 'failed_jobs', 'cache', 'cache_locks', 'job_batches', 'jobs', 'password_reset_tokens', 'personal_access_tokens', '']);
            });

            $permission = Permission::findOrFail($id);

            return view('dashboard.permission.edit', [
                'title' => 'Edit Permission',
                'permission' => $permission,
                'tables' => $filteredTables
            ]);
        }

        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'action' => 'required|string',
            'resource' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $slug = "{$request->action}-{$request->resource}";
        try {
            $permission->update([
                'action' => $request->action,
                'resource' => $request->resource,
                'slug' => $slug,
            ]);

            return redirect()->route('dashboard.permission.index')->with('success', 'Permission updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update data.']);
        }
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if ($permission->roles()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'This permission is in use by a role and cannot be deleted.']);
        }

        try {
            $permission->delete();

            return redirect()->route('dashboard.permission.index')->with('success', 'Permission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete data.']);
        }
    }

}
