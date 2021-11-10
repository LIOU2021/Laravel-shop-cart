@component('mail::message')
# 有用戶留言

name : {{$message['name']}}<br>
email : {{$message['email']}}<br>
content : {{$message['content']}}<br>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
