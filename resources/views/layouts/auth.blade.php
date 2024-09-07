<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>{{ env('APP_NAME') }} | {{ $title }}</title>
        <link rel="icon" href="{{ asset('img/logo-tk.png') }}" type="image/x-icon">
        @vite('resources/css/app.css')
    </head>
    <body class="flex justify-center items-center bg-[#051951] min-h-screen">
        @yield('content')

        @vite('resources/js/app.js')
    </body>
</html>
