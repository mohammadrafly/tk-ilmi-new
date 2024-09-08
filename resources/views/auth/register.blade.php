@extends('layouts.auth')

@section('content')

<div class="bg-white p-8 w-[400px] mx-auto mt-10">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Register Akun!</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-[#051951]">Name</label>
            <div class="mt-2">
                <input type="text" name="name" class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       id="name" placeholder="Enter Your Name" value="{{ old('name') }}" required>

                @error('name')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-[#051951]">Email</label>
            <div class="mt-2">
                <input type="email" name="email" class="w-full border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       id="email" placeholder="Enter Your Email" value="{{ old('email') }}" required>

                @error('email')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-[#051951]">Password</label>
            <div class="mt-2">
                <input type="password" name="password" class="w-full border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       id="password" placeholder="Enter Password" required>

                @error('password')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-[#051951]">Confirm Password</label>
            <div class="mt-2">
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       id="password_confirmation" placeholder="Confirm Password" required>
            </div>
        </div>

        <div class="mb-6">
            <label for="jk" class="block text-sm font-medium text-[#051951]">Gender</label>
            <div class="mt-2">
                <select id="jk" name="jk"
                        class="w-full border {{ $errors->has('jk') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
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

        <div class="mb-6 text-center">
            <div class="flex items-center justify-center">
                <input type="checkbox" id="user-checkbox1" name="terms" class="h-4 w-4 text-[#f18e00] focus:ring-[#f18e00] border-gray-300" required>
                <label for="user-checkbox1" class="ml-2 block text-sm text-[#051951]">I Agree to Terms & Conditions</label>
                @error('terms')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00]">
                <i class="icon-lock"></i> Register
            </button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">Already have an account?
            <a href="{{ route('login') }}" class="text-[#f18e00] hover:text-[#d77900] font-semibold">Login here</a>
        </p>
    </div>
</div>

@include('components.swal')

@endsection
