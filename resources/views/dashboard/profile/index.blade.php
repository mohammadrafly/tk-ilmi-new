@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Profile</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.update.profile', $data->email) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-[#051951]">Name</label>
            <div class="mt-2">
                <input id="name" type="text" name="name" value="{{ $data->name }}"
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
                <input id="email" type="email" name="email" value="{{ $data->email }}"
                       class="w-full border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Email" required>
                @error('email')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="role" class="block text-sm font-medium text-[#051951]">Role</label>
            <div class="mt-2">
                <select id="role" name="role"
                        class="w-full border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                        disabled>
                    <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="siswa" {{ $data->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label for="jk" class="block text-sm font-medium text-[#051951]">Gender</label>
            <div class="mt-2">
                <select id="jk" name="jk"
                        class="w-full border {{ $errors->has('jk') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                        required>
                    <option value="male" {{ $data->jk == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $data->jk == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('jk')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="foto" class="block text-sm font-medium text-[#051951]">Profile Photo</label>
            <div class="mt-2">
                @if($data->foto)
                    <img src="{{ Storage::url($data->foto) }}" alt="Profile Photo" class="h-20 w-20 object-cover rounded-full mb-4">
                @else
                    @php
                        $nameParts = explode(' ', trim(Auth::user()->name));
                        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                    @endphp
                    <div class="h-20 w-20 bg-gray-300 text-white flex items-center justify-center rounded-full mb-4">
                        <span class="text-xl font-bold">
                            {{ $initials }}
                        </span>
                    </div>
                @endif
                <input id="foto" type="file" name="foto"
                       class="w-full border {{ $errors->has('foto') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                @error('foto')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Update Profile
            </button>
        </div>
    </form>

    <hr class="my-8">

    <div class="bg-white mt-8">
        <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Change Password</div>

        <div class="mb-6 text-sm text-gray-600">
            <p class="font-semibold">Password Requirements:</p>
            <ul class="list-disc ml-5 mt-2">
                <li>At least 8 characters long</li>
                <li>Includes at least one uppercase letter (A-Z)</li>
                <li>Includes at least one number (0-9)</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('dashboard.update.password', $data->email) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="current_password" class="block text-sm font-medium text-[#051951]">Current Password</label>
                <div class="mt-2">
                    <input id="current_password" type="password" name="current_password"
                           class="w-full border {{ $errors->has('current_password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Current Password" required>
                    @error('current_password')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-[#051951]">New Password</label>
                <div class="mt-2">
                    <input id="password" type="password" name="password"
                           class="w-full border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter New Password" required>
                    @error('password')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-[#051951]">Confirm New Password</label>
                <div class="mt-2">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="w-full border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Confirm New Password" required>
                    @error('password_confirmation')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>

@include('components.swal')

@endsection
