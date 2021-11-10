<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand">Shop Cart</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="{{route('product')}}">商品</a>
                <a class="nav-item nav-link" href="/news">最新消息</a>
                <a class="nav-item nav-link" href="/contactUs">聯絡我們</a>

                @if(Auth::check())
                @include('layout.userNav')
                @else
                    <a class="btn btn-outline-light" href="{{route('login')}}">登入</a>
                @endif
                

            </div>
        </div>
    </nav>