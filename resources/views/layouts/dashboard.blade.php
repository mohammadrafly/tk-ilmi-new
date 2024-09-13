<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>{{ env('APP_NAME') }} | {{ $title }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('img/logo-tk.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="flex h-screen bg-gray-100">
    <div class="flex w-full h-full">
        <aside class="w-fit bg-[#051951] text-white flex-shrink-0">
            @include('dashboard.partials.sidebar')
        </aside>
        <main class="flex-1 flex flex-col overflow-y-auto bg-gray-100 py-5">
            @yield('content')
        </main>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    @vite('resources/js/app.js')
    @yield('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function closeMessage(id) {
                const messageElement = document.getElementById(id);
                if (messageElement) {
                    messageElement.style.opacity = '0';
                    setTimeout(() => {
                        messageElement.remove();
                    }, 300);
                }
            }

            setTimeout(() => {
                closeMessage('error-message');
                closeMessage('success-message');
            }, 3000);
        });
    </script>
</body>
</html>
