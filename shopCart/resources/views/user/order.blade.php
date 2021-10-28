@extends('layout.app')

@section('title','個人訂單')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
</link>
<style>

</style>
@endsection('css')

@section('js')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    function createtable() {
        $('#orderTable').DataTable({
            "order": [
                [1, "desc"]
            ]
        });
    }

    function deleteEvent() {

        $('#deleteBtn').click(function() {
            let selectlen = $("#orderTable input[type='checkbox']:checked").length;
            for (i = 0; i < selectlen; i++) {
                let orderId = $("#orderTable input[type='checkbox']:checked").eq(i).parent().parent().children().eq(1).text();
                let url = '/api/order/' + orderId;
                // console.log(orderId);
                // console.log(url);
                console.log('delete id : '+orderId);
                axios.delete(url).then(function(){
                    window.location.reload();
                });
            
            }
            
        });
    }

    $(function() {

        // http://127.0.0.1:8000/orders/5
        let userDetail = $("#userDetail").text();
        let userId = JSON.parse(userDetail)['id'];
        let url = "http://127.0.0.1:8000/orders/" + userId;
        axios.get(url).then(function(e) {
            let data = e.data;
            let tbodyHtml = "";

            for (i = 0; i < data.length; i++) {
                tbodyHtml += "<tr>";
                tbodyHtml += `<td><input type='checkbox' style='width:100px;height:50px;'></td>`;
                tbodyHtml += `<td>${data[i].id}</td>`;
                tbodyHtml += `<td>${data[i].date}</td>`;
                tbodyHtml += `<td>${data[i].name}</td>`;
                tbodyHtml += `<td>${data[i].price}</td>`;
                tbodyHtml += `<td>${data[i].qty}</td>`;
                tbodyHtml += `<td><img class="w-50 h-50" src="/images/${data[i].imgUrl}"/></td>`;
                tbodyHtml += "</tr>";
            }

            $("#orderTable tbody").html(tbodyHtml);
            createtable();
            deleteEvent();
        });



    })
</script>
@endsection('js')

@section('content')
<div class="d-none" id="userDetail">{{Auth::user()}}</div>
<h1 class="mx-auto text-center mt-3">個人訂單</h1>
<button id='deleteBtn' class="btn btn-danger">刪除</button>

<table id="orderTable" class="display">
    <thead>
        <th>選擇</th>
        <th>訂單編號</th>
        <th>訂單日期</th>
        <th>商品名稱</th>
        <th>價格</th>
        <th>數量</th>
        <th>圖示</th>
    </thead>
    <tbody>

    </tbody>
</table>

@endsection