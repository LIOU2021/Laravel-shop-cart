@component('mail::message')
# 訂單通知

訂單編號 : {{$orderId}} <br>
已取消。<br>

<a href="http://127.0.0.1:8000/user/order">前往查看訂單明細</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
