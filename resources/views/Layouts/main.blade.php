<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fa/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('bs/css/bootstrap.min.css') }}">
    <title>{{ $title }} Page</title>
</head>
<body>
    <div class="row mt-5">
        @yield('content')
    </div>
    @stack('modal')
    
    <script src="{{ asset('bs/js/bootstrap.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @stack('js')


</body>
</html>