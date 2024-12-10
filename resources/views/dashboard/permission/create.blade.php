@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-[#051951] mb-4">{{ $title }}</h1>

    <form action="{{ route('dashboard.permission.create') }}" method="POST" class="bg-white shadow-md rounded-md p-6 space-y-6">
        @csrf

        <div>
            <label for="action" class="block text-sm font-medium text-gray-700">Action</label>
            <select id="action" name="action"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="" disabled selected>Select an action</option>
                <option value="create">Create</option>
                <option value="read">Read</option>
                <option value="update">Update</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div>
            <label for="resource" class="block text-sm font-medium text-gray-700">Resource</label>
            <select id="resource" name="resource"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                <option value="" disabled selected>Select a resource</option>
                @foreach($tables as $table)
                    <option value="{{ $table }}">{{ $table }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <a href="{{ route('dashboard.permission.index') }}"
               class="inline-block bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-300 ease-in-out">
               Cancel
            </a>
            <button type="submit"
                    class="bg-[#f18e00] text-white px-4 py-2 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out">
                Save Permission
            </button>
        </div>
    </form>
</div>

@endsection
