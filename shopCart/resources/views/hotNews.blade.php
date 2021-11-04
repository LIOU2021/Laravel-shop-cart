@extends('layout.app')

@section('title','HotNews')

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
                [0, "asc"]
            ]
        });
    })
</script>
@endsection('js')

@section('content')
<h1 class=" text-center mx-auto">熱門消息排行</h1>

<table id="newsTable" class="display">
    <thead>
        <th>排名</th>
        <th>日期</th>
        <th>標題</th>
        <th>觀看次數</th>
    </thead>
    <tbody>
        @foreach($data as $popularNews=>$value)
        <tr>
            <td>{{$popularNews+1}}</td>
            <td>{{$value['date']}}</td>
            <td><a href="/news/{{$value['id']}}">{{$value['title']}}</a></td>
            <td class="text-right">{{$value['views']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection