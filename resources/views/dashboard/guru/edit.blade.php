@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Edit Guru</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.guru.edit', $guru->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="user_id" class="block text-sm font-medium text-[#051951]">User ID</label>
            <div class="mt-2">
                <select id="user_id" name="user_id"
                        class="w-full border {{ $errors->has('user_id') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                        required>
                    <option value="" disabled>Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $guru->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->id }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="nip" class="block text-sm font-medium text-[#051951]">NIP</label>
            <div class="mt-2">
                <input id="nip" type="text" name="nip" value="{{ old('nip', $guru->nip) }}"
                       class="w-full border {{ $errors->has('nip') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter NIP" maxlength="18" required>
                @error('nip')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="alamat" class="block text-sm font-medium text-[#051951]">Address</label>
            <div class="mt-2">
                <input id="alamat" type="text" name="alamat" value="{{ old('alamat', $guru->alamat) }}"
                       class="w-full border {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Address" required>
                @error('alamat')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="no_telp" class="block text-sm font-medium text-[#051951]">Phone Number</label>
            <div class="mt-2">
                <input id="no_telp" type="text" name="no_telp" value="{{ old('no_telp', $guru->no_telp) }}"
                       class="w-full border {{ $errors->has('no_telp') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Phone Number" required>
                @error('no_telp')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Update Guru
            </button>
        </div>
    </form>
</div>

@include('components.swal')

@endsection
