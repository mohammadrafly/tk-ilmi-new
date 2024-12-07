<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission as PermissionModel;
use Illuminate\Support\Facades\DB;


class PermissionSeeder extends Seeder
{
    public function run()
    {
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);

        $filteredTables = array_filter($tableNames, function ($table) {
            return !in_array($table, [
                'migrations', 'password_resets', 'failed_jobs', 'cache', 'cache_locks', 'job_batches', 'jobs',
                'password_reset_tokens', 'personal_access_tokens', ''
            ]);
        });

        foreach ($filteredTables as $table) {
            $this->createCrudPermissionsForResource($table);
        }
    }

    /**
     * Create CRUD permissions for a given resource (table).
     *
     * @param string $resource
     * @return void
     */
    protected function createCrudPermissionsForResource(string $resource)
    {
        $permissions = [
            ['action' => 'create', 'resource' => $resource, 'slug' => 'create-' . $resource],
            ['action' => 'read', 'resource' => $resource, 'slug' => 'read-' . $resource],
            ['action' => 'update', 'resource' => $resource, 'slug' => 'update-' . $resource],
            ['action' => 'delete', 'resource' => $resource, 'slug' => 'delete-' . $resource],
        ];

        foreach ($permissions as $permission) {
            PermissionModel::firstOrCreate([
                'slug' => $permission['slug']
            ], [
                'action' => $permission['action'],
                'resource' => $permission['resource']
            ]);
        }
    }
}
