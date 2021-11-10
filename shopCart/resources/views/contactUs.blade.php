@extends('layout.app')

@section('title','聯絡我們')

@section('css')
<style>

</style>
@endsection('css')

@section('js')
<script>
    $(function() {

    })
</script>
@endsection('js')

@section('content')
<h1 class="text-center mx-auto">聯絡我們</h1>
<form action="/contactUs" method="POST" class="mx-auto text-center">
    @csrf
    <label for="">
        name
        <input type="text" name="name">
    </label><br>
    
    <label for="">
        email
        <input type="text" name="email">
    </label><br>

    <label for="content" class="text-left">
        內容
    </label>
    <br>
    <textarea name="content" id="content" cols="30" rows="10"></textarea>
    <br>
    <button type="submit" class="btn btn-primary">提交</button>
</form>
@endsection