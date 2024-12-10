@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-[#051951] mb-4">Edit Role</h1>

    <form action="{{ route('dashboard.roles.update', $role->id) }}" method="POST" class="bg-white shadow-md rounded-md p-6 space-y-6">
        @csrf
        @method('PUT') <!-- Used for update (POST request) -->

        <div>
            <label for="roleName" class="block text-sm font-medium text-gray-700">Role Name</label>
            <input type="text" id="roleName" name="name"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Enter role name" value="{{ old('name', $role->name) }}" required>
        </div>

        <div>
            <label for="permissions" class="block text-sm font-medium text-gray-700">Assign Permissions</label>
            <div class="mt-2 grid grid-cols-2 gap-4">
                @foreach($permissions as $permission)
                    <div class="flex items-center">
                        <input type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->slug }}"
                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                               @if($role->permissions->contains('slug', $permission->slug)) checked @endif>
                        <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->slug }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-right">
            <a href="{{ route('dashboard.roles.index') }}"
               class="inline-block bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-300 ease-in-out">
               Cancel
            </a>
            <button type="submit"
                    class="bg-[#f18e00] text-white px-4 py-2 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out">
                Update Role
            </button>
        </div>
    </form>
</div>

@endsection
