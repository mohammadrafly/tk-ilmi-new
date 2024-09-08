@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Create New User</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.user.create') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-[#051951]">Name</label>
            <div class="mt-2">
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Name" required>
                @error('name')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-[#051951]">Email</label>
            <div class="mt-2">
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="w-full border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Email" required>
                @error('email')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-[#051951]">Password</label>
            <div class="mt-2">
                <input id="password" type="password" name="password"
                       class="w-full border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Password" required>
                @error('password')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-[#051951]">Confirm Password</label>
            <div class="mt-2">
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="w-full border border-gray-300 shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Confirm Password" required>
            </div>
        </div>

        <div class="mb-6">
            <label for="role" class="block text-sm font-medium text-[#051951]">Role</label>
            <div class="mt-2">
                <select id="role" name="role"
                        class="w-full border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                        required>
                    <option value="" disabled>Select Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('role')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="jk" class="block text-sm font-medium text-[#051951]">Gender</label>
            <div class="mt-2">
                <select id="jk" name="jk"
                        class="w-full border {{ $errors->has('jk') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                        required>
                    <option value="" disabled>Select Gender</option>
                    <option value="male" {{ old('jk') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('jk') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('jk')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="foto" class="block text-sm font-medium text-[#051951]">Foto</label>
            <div class="mt-2">
                <input id="foto" type="file" name="foto"
                       class="w-full border border-gray-300 shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Create User
            </button>
        </div>
    </form>
</div>

@include('components.swal')

@endsection
