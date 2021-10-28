<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signUp</title>

    @include('cdn.bootstrap')

</head>

<body>
    <div class="container text-center mt-5">
        <h1 class="text-light bg-dark">註冊</h1>
        <form action="{{route('signUp')}}" method="post" class="w-50 mx-auto">
            @csrf
            <div class="form-group">
                <label for="name" class="col-2">
                    name
                </label>
                <input id='name' class = "ml-2" type="text" name="name">
            </div>

            <div class="form-group">
                <label for="email" class="col-2">
                    email
                </label>
                <input id="email" class = "ml-2" type="email" name="email">
            </div>

            <div class="form-group">
                <label for="password" class="col-2">
                    password
                </label>
                <input id="password" class = "ml-2" type="password" name="password">
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