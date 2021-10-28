<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('cdn.bootstrap')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    </script>
    @yield('css')

    @yield('js')


    <title>@yield('title')</title>
</head>

<body>

    @include('layout.guestNav')

    <div class="container-fluid">
        @yield('content')
    </div>

    <footer class="bg-dark text-center text-white fixed-bottom">
        © 2020 Copyright
    </footer>

</body>

</html>