@component('mail::message')
# 訂單成立通知

提醒您，有新的訂單成立<br>
訂單編號為 : {{$orderId}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
