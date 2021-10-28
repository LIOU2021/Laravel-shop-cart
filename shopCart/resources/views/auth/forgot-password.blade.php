<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('cdn.bootstrap')

    <title>忘記密碼</title>
</head>

<body>

    <div class="container text-center mt-5">


        <h1>forgot-password</h1>

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form action="{{route('password.email')}}" method="POST" class="w-50 mx-auto">
            @csrf
            <div class="form-group">
                <label for='email' class="col-2">
                    email
                </label>
                <input id='email' type="email" name='email' require>
            </div>

            <div class="row w-75 mx-auto">
                <input type="submit" class="form-control bg-success">
            </div>
        </form>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>







</body>

</html>