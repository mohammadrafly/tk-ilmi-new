@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Edit Agama</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.agama.edit', $agama->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="nama" class="block text-sm font-medium text-[#051951]">Nama Agama</label>
            <div class="mt-2">
                <input id="nama" type="text" name="nama" value="{{ old('nama', $agama->nama) }}"
                       class="w-full border {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Religion Name" required>
                @error('nama')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Update Agama
            </button>
        </div>
    </form>
</div>

@include('components.swal')

@endsection
