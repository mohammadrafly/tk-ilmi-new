@extends('layouts.auth')

@section('content')

<div class="bg-white p-8 w-[400px] mx-auto mt-10">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951] uppercase tracking-wide">{{ $title }}</div>

    <div class="w-full">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-[#051951]">Email</label>
                <div class="mt-2">
                    <input id="email" type="email" class="form-input w-full border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email" autofocus>
                    @if ($errors->has('email'))
                        <span class="text-red-500 text-sm mt-2">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-[#051951]">Password</label>
                <div class="mt-2">
                    <input id="password" type="password" class="form-input w-full border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           name="password" required autocomplete="current-password" placeholder="Enter your password">
                    @error('password')
                        <span class="text-red-500 text-sm mt-2">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-[#f18e00] focus:ring-[#f18e00] border-gray-300">
                    <label for="remember" class="ml-2 block text-sm text-[#051951]">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00]">
                    Login
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Don't have an account?
                <a href="{{ route('register') }}" class="text-[#f18e00] hover:text-[#d77900] font-semibold">Register here</a>
            </p>
        </div>
    </div>
</div>

@include('components.swal')

@endsection
