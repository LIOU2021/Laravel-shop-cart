@extends('layout.app')

@section('title','newsDetail')

@section('css')
<style>
    pre {
        word-wrap: break-word;
        word-break: break-all;
        overflow: hidden;
    }
</style>
@endsection('css')

@section('js')
<script>
    $(function() {

    })
</script>
@endsection('js')

@section('content')
<h1 class="mt-3">{{$data->title}}</h1>
<hr>
<pre>{{$data->content}}</pre>

@endsection