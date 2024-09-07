@extends('layouts.auth')

@section('content')

<div class="bg-white p-8 w-[400px] mx-auto mt-10">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Register Akun!</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6">
            <label for="input-1" class="block text-sm font-medium text-[#051951]">Email</label>
            <div class="mt-2">
                <input type="text" name="email" class="w-full border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       id="input-1" placeholder="Enter Your Email" value="{{ old('email') }}" required>

                @error('email')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="input-4" class="block text-sm font-medium text-[#051951]">Password</label>
            <div class="mt-2">
                <input type="password" name="password" class="w-full border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       id="input-4" placeholder="Enter Password" required>

                @error('password')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="input-5" class="block text-sm font-medium text-[#051951]">Confirm Password</label>
            <div class="mt-2">
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       id="input-5" placeholder="Confirm Password" required>
            </div>
        </div>

        <div class="mb-6 text-center">
            <div class="flex items-center justify-center">
                <input type="checkbox" id="user-checkbox1" class="h-4 w-4 text-[#f18e00] focus:ring-[#f18e00] border-gray-300" checked>
                <label for="user-checkbox1" class="ml-2 block text-sm text-[#051951]">I Agree Terms & Conditions</label>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00]">
                <i class="icon-lock"></i> Register
            </button>
        </div>
    </form>
</div>

@include('components.swal')

@endsection
