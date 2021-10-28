@extends('layout.admin')

@section('title','最新消息中心')

@section('js')
<script>
    // datatable 前置設定 (開始)
    let datatable_start="Y";
    let datatable_getAlldata ="{{route('newsJson')}}";
    let datatable_createData ="http://127.0.0.1:8000/news";
    let datatable_deleteData = "http://127.0.0.1:8000/news/";
    let datatable_updateData = "http://127.0.0.1:8000/news/";
    let datatable_title=['id','date','title','content'];
    let datatable_pk=['id'];
    let datatable_sortBy="2";

    // datatable 前置設定 (結束)
</script>
@endsection

@section('content')

<h1 class="mx-auto text-center mt-5">這裡news中心</h1>

<table id="datatable" class="display">
    
</table>

@endsection