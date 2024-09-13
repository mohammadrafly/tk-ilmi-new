@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 min-w-[600px] mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Edit Program Semester</div>
    <hr class="mb-6">

    <form method="POST" action="{{ route('dashboard.programsemester.edit', $programSemester->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="tahun_ajaran" class="block text-sm font-medium text-[#051951]">Tahun Ajaran</label>
            <div class="mt-2">
                <select id="tahun_ajaran" name="tahun_ajaran" class="w-full border {{ $errors->has('tahun_ajaran') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                    @foreach ($tahunajaran as $tahun)
                        <option value="{{ $tahun->id }}" {{ old('tahun_ajaran', $programSemester->tahun_ajaran) == $tahun->id ? 'selected' : '' }}>
                            {{ $tahun->tahunawal }} - {{ $tahun->tahunakhir }}
                        </option>
                    @endforeach
                </select>
                @error('tahun_ajaran')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="semester" class="block text-sm font-medium text-[#051951]">Semester</label>
            <div class="mt-2">
                <select id="semester" name="semester" class="w-full border {{ $errors->has('semester') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                    <option value="1" {{ old('semester', $programSemester->semester) == '1' ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ old('semester', $programSemester->semester) == '2' ? 'selected' : '' }}>Semester 2</option>
                </select>
                @error('semester')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="bulan" class="block text-sm font-medium text-[#051951]">Bulan</label>
            <div class="mt-2">
                <input id="bulan" type="text" name="bulan" value="{{ old('bulan', $programSemester->bulan) }}"
                       class="w-full border {{ $errors->has('bulan') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Month" required>
                @error('bulan')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="topik" class="block text-sm font-medium text-[#051951]">Topik</label>
            <div class="mt-2">
                <input id="topik" type="text" name="topik" value="{{ old('topik', $programSemester->topik) }}"
                       class="w-full border {{ $errors->has('topik') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Topic" required>
                @error('topik')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="minggu1" class="block text-sm font-medium text-[#051951]">Minggu 1</label>
            <div class="mt-2">
                <input id="minggu1" type="text" name="minggu1" value="{{ old('minggu1', $programSemester->minggu1) }}"
                       class="w-full border {{ $errors->has('minggu1') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Week 1" required>
                @error('minggu1')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="minggu2" class="block text-sm font-medium text-[#051951]">Minggu 2</label>
            <div class="mt-2">
                <input id="minggu2" type="text" name="minggu2" value="{{ old('minggu2', $programSemester->minggu2) }}"
                       class="w-full border {{ $errors->has('minggu2') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Week 2" required>
                @error('minggu2')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="minggu3" class="block text-sm font-medium text-[#051951]">Minggu 3</label>
            <div class="mt-2">
                <input id="minggu3" type="text" name="minggu3" value="{{ old('minggu3', $programSemester->minggu3) }}"
                       class="w-full border {{ $errors->has('minggu3') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Week 3" required>
                @error('minggu3')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="minggu4" class="block text-sm font-medium text-[#051951]">Minggu 4</label>
            <div class="mt-2">
                <input id="minggu4" type="text" name="minggu4" value="{{ old('minggu4', $programSemester->minggu4) }}"
                       class="w-full border {{ $errors->has('minggu4') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                       placeholder="Enter Week 4" required>
                @error('minggu4')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                Update Program Semester
            </button>
        </div>
    </form>
</div>

@include('components.swal')

@endsection
