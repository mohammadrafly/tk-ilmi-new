@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Create New Tahun Ajaran</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.tahunajaran.create') }}">
        @csrf

        <div class="mb-6">
            <label for="tahunawal" class="block text-sm font-medium text-[#051951]">Tahun Awal</label>
            <div class="mt-2">
                <input id="tahunawal" type="number" name="tahunawal" value="{{ old('tahunawal') }}"
                       class="w-full border {{ $errors->has('tahunawal') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Start Year" min="1900" max="{{ date('Y') }}" required>
                @error('tahunawal')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="tahunakhir" class="block text-sm font-medium text-[#051951]">Tahun Akhir</label>
            <div class="mt-2">
                <input id="tahunakhir" type="number" name="tahunakhir" value="{{ old('tahunakhir') }}"
                       class="w-full border {{ $errors->has('tahunakhir') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter End Year" min="{{ date('Y') }}" required>
                @error('tahunakhir')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Create Tahun Ajaran
            </button>
        </div>
    </form>
</div>

@include('components.swal')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tahunAwalInput = document.getElementById('tahunawal');
    const tahunAkhirInput = document.getElementById('tahunakhir');

    tahunAwalInput.addEventListener('input', function() {
        const tahunAwal = parseInt(tahunAwalInput.value, 10);
        if (!isNaN(tahunAwal)) {
            tahunAkhirInput.value = tahunAwal + 1;
        }
    });

    if (tahunAwalInput.value) {
        tahunAwalInput.dispatchEvent(new Event('input'));
    }
});
</script>

@endsection
