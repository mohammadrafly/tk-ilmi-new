@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Edit Guru</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.guru.edit', $guru->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="nama" class="block text-sm font-medium text-[#051951]">Nama</label>
            <div class="mt-2">
                <input id="nama" type="text" name="nama" value="{{ old('nama', $guru->nama) }}"
                       class="w-full border {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Guru's Name" required>
                @error('nama')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="no_telp" class="block text-sm font-medium text-[#051951]">No Telepon</label>
            <div class="mt-2">
                <input id="no_telp" type="text" name="no_telp" value="{{ old('no_telp', $guru->no_telp) }}"
                       class="w-full border {{ $errors->has('no_telp') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Phone Number" required>
                @error('no_telp')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="text" class="block text-sm font-medium text-[#051951]">Alamat</label>
            <div class="mt-2">
                <textarea id="alamat" name="alamat" rows="4"
                          class="w-full border {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                          placeholder="Enter a description">{{ old('alamat', $guru->alamat) }}</textarea>
                @error('alamat')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="img" class="block text-sm font-medium text-[#051951]">Foto Guru</label>
            <div class="mt-2">
                @if($guru->img)
                    <img src="{{ Storage::url($guru->img) }}" alt="Foto Guru" class="w-32 h-32 object-cover mb-4">
                @endif
                <input id="img" type="file" name="img"
                       class="w-full border {{ $errors->has('img') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                @error('img')
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
