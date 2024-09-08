@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-[#051951] mb-4">{{ $title }}</h1>

    <div class="mb-4">
        <a href="{{ route('dashboard.guru.create') }}" class="bg-[#f18e00] text-white px-4 py-2 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out">
            Add New Guru
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-md">
        <table class="w-full min-w-full divide-y divide-gray-200">
            <thead class="bg-[#051951] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">NIP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Phone Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data as $guru)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $guru->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guru->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guru->alamat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guru->no_telp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('dashboard.guru.edit', $guru->id) }}" class="text-[#f18e00] hover:text-[#d77900]">Edit</a>
                            <form action="{{ route('dashboard.guru.delete', $guru->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800 ml-4" onclick="confirmDelete(event, this.form)">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
