@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-[#051951] mb-4">{{ $title }}</h1>

    <form method="POST" action="{{ route('dashboard.permission.update', $permission->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="action" class="block text-sm font-medium text-gray-700">Action</label>
            <select id="action" name="action" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="create" {{ $permission->action == 'create' ? 'selected' : '' }}>Create</option>
                <option value="read" {{ $permission->action == 'read' ? 'selected' : '' }}>Read</option>
                <option value="update" {{ $permission->action == 'update' ? 'selected' : '' }}>Update</option>
                <option value="delete" {{ $permission->action == 'delete' ? 'selected' : '' }}>Delete</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="resource" class="block text-sm font-medium text-gray-700">Resource</label>
            <select id="resource" name="resource"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                <option value="" disabled selected>Select a resource</option>
                @foreach($tables as $table)
                    <option value="{{ $table }}" {{ $permission->resource == $table ? 'selected' : '' }}>{{ $table }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Update Permission</button>
        </div>
    </form>
</div>
@endsection
