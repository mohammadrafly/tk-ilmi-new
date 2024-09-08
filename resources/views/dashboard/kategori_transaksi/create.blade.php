@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Create New Kategori Transaksi</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.kategori.create') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="nama" class="block text-sm font-medium text-[#051951]">Nama Kategori Transaksi</label>
            <div class="mt-2">
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}"
                       class="w-full border {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Category Name" required>
                @error('nama')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="harga" class="block text-sm font-medium text-[#051951]">Harga</label>
            <div class="mt-2">
                <input id="harga" type="number" name="harga" value="{{ old('harga') }}"
                       class="w-full border {{ $errors->has('harga') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Price" required>
                @error('harga')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="interval" class="block text-sm font-medium text-[#051951]">Interval</label>
            <div class="mt-2">
                <input id="interval" type="number" name="interval" value="{{ old('interval') }}"
                       class="w-full border {{ $errors->has('interval') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Interval (in days)" required>
                @error('interval')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Create Kategori Transaksi
            </button>
        </div>
    </form>
</div>

@include('components.swal')

@endsection
