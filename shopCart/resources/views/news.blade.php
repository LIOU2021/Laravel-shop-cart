@extends('layout.app')

@section('title','News')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
</link>
<style>

</style>
@endsection('css')

@section('js')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        $('#newsTable').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    })
</script>
@endsection('js')

@section('content')
<h1 class=" text-center mx-auto">最新消息</h1>

<table id="newsTable" class="display">
    <thead>
        <th>日期</th>
        <th>標題</th>
    </thead>
    <tbody>
        @foreach($data as $news)
        <tr>
            <td>{{$news->date}}</td>
            <td><a href="news/{{$news->id}}">{{$news->title}}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection