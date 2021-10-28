<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('cdn.bootstrap')

    <title>重設密碼</title>
</head>

<body>

    <div class="container text-center mt-5">


        <h1 class="bg-primary w-50 text-center mx-auto">reset-password</h1>

        <form action="{{route('password.update')}}" method="POST" class="w-50 mx-auto">
        @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for='email' class="col-2">
                    email
                </label>
                <input id='email' type="email" name='email' require>
            </div>
            
            <div class="form-group">
                <label for='password' class="col-2">
                    新設密碼
                </label>
                <input id='password' type="password" name='password' require>
            </div>

            <div class="form-group">
                <label for='password_confirmation' class="col-2">
                    確認密碼
                </label>
                <input id='password_confirmation' type="password" name='password_confirmation' require>
            </div>
            

            <div class="row w-75 mx-auto">
                <input type="submit" class="form-control bg-success">
            </div>

        </form>
        
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