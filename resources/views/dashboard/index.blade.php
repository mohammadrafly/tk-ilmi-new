@extends('layouts.dashboard')

@section('content')

<div class="flex-1 p-8">
    @if (session('error'))
        <div id="error-message" class="mt-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded relative">
            <button id="close-btn" class="absolute top-2 right-2 text-red-500 hover:text-red-700">×</button>
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function() {
                var errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            }, 5000);

            document.getElementById('close-btn').addEventListener('click', function() {
                var errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            });
        </script>
    @endif
    <h2 class="text-2xl font-bold text-[#051951]">Welcome to your Dashboard</h2>
    <p class="mt-4 text-gray-600">This is your main dashboard area. You can add content here.</p>
</div>

@endsection
