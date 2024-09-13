@if ($errors->any() || session('success') || session('error'))
<div id="message-container" class="mb-6 fixed top-0 right-0 mt-4 mr-4 z-50">
    @if ($errors->any())
        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative opacity-100 transition-opacity duration-300" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $errors->first() }}</span>
            <button onclick="closeMessage('error-message')" class="absolute top-0 right-0 mt-2 mr-2 text-red-700 hover:text-red-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div id="session-error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative opacity-100 transition-opacity duration-300" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <button onclick="closeMessage('session-error-message')" class="absolute top-0 right-0 mt-2 mr-2 text-red-700 hover:text-red-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    @if (session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative opacity-100 transition-opacity duration-300" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="closeMessage('success-message')" class="absolute top-0 right-0 mt-2 mr-2 text-green-700 hover:text-green-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif
</div>
@endif
