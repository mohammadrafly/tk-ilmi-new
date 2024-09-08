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

    @vite('resources/js/app.js')
</body>
</html>
