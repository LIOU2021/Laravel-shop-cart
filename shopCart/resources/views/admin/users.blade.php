@extends('layout.admin')

@section('title','用戶中心')

@section('js')
<script>
    // datatable 前置設定 (開始)
    let restfulApi = "http://127.0.0.1:8000/api/user";

    let datatable_start = "Y";
    let datatable_getAlldata = restfulApi;
    let datatable_createData = restfulApi;
    let datatable_deleteData = restfulApi + "/";
    let datatable_updateData = restfulApi + "/";
    let datatable_title = ['id', 'name', 'email', "password", "admin"];
    let datatable_pk = ['id'];
    let datatable_sortBy = "2";

    function datatable_customerFunc() {
        $('#updateData').click(function(){
            $("#password").parent().hide();
        })
    }
    // datatable 前置設定 (結束)
</script>

@endsection

@section('content')

<h1 class="mx-auto text-center mt-5">這裡users中心</h1>

<table id="datatable" class="display">

</table>
@endsection