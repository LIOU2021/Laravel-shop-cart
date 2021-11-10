@component('mail::message')
# 訂單通知

您下訂了一筆訂單。<br>
訂單編號 : {{$order->id}}<br>
<a href="http://127.0.0.1:8000/user/order">前往查看訂單明細</a>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
