@component('mail::message')
{{$name}} 您好 :

您成功使用 {{$email}} 註冊了我們的會員。

Thanks,<br>
{{ config('app.name') }}
@endcomponent
