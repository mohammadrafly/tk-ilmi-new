@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-[#051951] mb-4">{{ $title }}</h1>

    @include('components.message')

    <div class="mb-4">
        <a href="{{ route('dashboard.roles.create') }}" class="bg-[#f18e00] text-white px-4 py-2 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out">
            Add New Role
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-md">
        <table class="w-full min-w-full divide-y divide-gray-200">
            <thead class="bg-[#051951] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Role ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Role Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Permissions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data as $role)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $role->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $role->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($role->permissions->isNotEmpty())
                                <div x-data="{ showAll: false }" class="flex flex-wrap gap-2">
                                    <template x-if="!showAll">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($role->permissions->take(4) as $permission)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium py-1 px-2 rounded-full">
                                                    {{ $permission->name }} <span class="text-xs text-gray-500">({{ $permission->slug }})</span>
                                                </span>
                                            @endforeach
                                            @if($role->permissions->count() > 4)
                                                <button
                                                    @click="showAll = true"
                                                    class="inline-block bg-gray-100 text-gray-800 text-xs font-medium py-1 px-2 rounded-full hover:bg-gray-200">
                                                    +{{ $role->permissions->count() - 4 }} more
                                                </button>
                                            @endif
                                        </div>
                                    </template>

                                    <template x-if="showAll">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($role->permissions as $permission)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium py-1 px-2 rounded-full">
                                                    {{ $permission->name }} <span class="text-xs text-gray-500">({{ $permission->slug }})</span>
                                                </span>
                                            @endforeach
                                            <button
                                                @click="showAll = false"
                                                class="inline-block bg-gray-100 text-gray-800 text-xs font-medium py-1 px-2 rounded-full hover:bg-gray-200">
                                                Show Less
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            @else
                                <span class="text-gray-400">No Permissions Assigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('dashboard.roles.update', $role->id) }}" class="text-[#f18e00] hover:text-[#d77900]">Edit</a>
                            <form action="{{ route('dashboard.roles.delete', $role->id) }}" method="POST" class="inline">
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

<script>
    function confirmDelete(event, form) {
        event.preventDefault();
        if (confirm("Are you sure you want to delete this role?")) {
            form.submit();
        }
    }
</script>

@endsection
