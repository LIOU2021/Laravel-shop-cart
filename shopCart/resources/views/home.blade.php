@extends('layout.app')

@section('title','Home')

@section('css')
<style>
    h1{
        color: red;
    }
</style>
@endsection('css')

@section('js')
<script>
    $(function(){
        $('#test').click(function(){
            alert(this.innerText);
        })
    })
</script>
@endsection('js')

@section('content')
    <h1 id='test'>i am home</h1>
    <div>{{Auth::user()}}</div>
@endsection