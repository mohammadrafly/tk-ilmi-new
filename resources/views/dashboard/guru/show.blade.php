@extends('layouts.dashboard')

@section('content')

<div class="flex-1 p-8">
    <h2 class="text-2xl font-bold text-[#051951]">{{ $title }}</h2>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($data as $teacher)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                @if ($teacher->img)
                    <img src="{{ Storage::url($teacher->img) }}" alt="Teacher Photo" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-xl font-bold text-gray-800">
                        {{ strtoupper(substr($teacher->nama, 0, 1)) }}
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-[#051951]">{{ $teacher->nama }}</h3>
                    <p class="text-gray-600 mt-1">{{ $teacher->no_telp }}</p>
                    <p class="text-gray-600 mt-1">{{ $teacher->alamat }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
