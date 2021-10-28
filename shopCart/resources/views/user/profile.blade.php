@extends('layout.app')

@section('title','Profile')


@section('content')
<h1 class="mx-auto text-center mt-2">
    個人資料
    <form action="/api/user/{{Auth::id()}}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name" class="col-2">
                name
            </label>
            <input id='name' class="ml-2" type="text" name="name" value="{{Auth::user()->name}}">
        </div>

        <div class="form-group">
            <label for="email" class="col-2">
                email
            </label>
            <input id="email" class="ml-2" type="email" name="email" value="{{Auth::user()->email}}">
        </div>

        <div class="form-group w-50 mx-auto">
            <input type="submit" class="form-control bg-success">
        </div>

    </form>
    @if(session('status'))
    <div class="alert alert-success">
        {{session('status')." - ".date('Y/m/d H:i:s');}}
    </div>
    @endif
    
</h1>

@endsection