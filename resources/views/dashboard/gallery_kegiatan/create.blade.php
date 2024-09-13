@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Create New Kegiatan</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.gallerykegiatan.create') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-[#051951]">Title</label>
            <div class="mt-2">
                <input id="title" type="text" name="title" value="{{ old('title') }}"
                       class="w-full border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Kegiatan Title" required>
                @error('title')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="tanggal" class="block text-sm font-medium text-[#051951]">Tanggal</label>
            <div class="mt-2">
                <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal') }}"
                       class="w-full border {{ $errors->has('tanggal') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Date" required>
                @error('tanggal')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="img" class="block text-sm font-medium text-[#051951]">Image</label>
            <div class="mt-2">
                <input id="img" type="file" name="img"
                       class="w-full border {{ $errors->has('img') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                @error('img')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Create Kegiatan
            </button>
        </div>
    </form>
</div>

@include('components.swal')

@endsection
