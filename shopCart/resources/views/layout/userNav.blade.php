
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        用戶資訊
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('user.order')}}">訂單</a>
                        <a class="dropdown-item" href="{{route('user.profile')}}">個人檔案</a>
                    @if(Auth::user()->admin)
                        <a class="dropdown-item" href="{{route('admin.center')}}">管理員中心</a>
                    @endif

                    </div>
                </li>

                <span class="navbar-text">
                    {{Auth::user()->name}} 歡迎登入
                </span>
                <a class="btn btn-outline-light" href="{{route('logout')}}">登出</a>

 