<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @include('cdn.bootstrap')
    @include('layout.datatable')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sidebars/">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('adminSideBar/assets/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('adminSideBar/sidebars/sidebars.css')}}" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <script>
        function sidebarHover() {
            $('.nav-item a').hover(
                function() {
                    $(this).css('background-color', 'DarkGray');
                },
                function() {
                    $(this).css('background-color', '');
                }
            )
        }

        function sidebarShowActive() {
            let pagePath = window.location.pathname.split("/")[2];
            $(`#${pagePath}`).addClass('active');
        }

        $(function() {
            sidebarShowActive();
            sidebarHover();
        })
    </script>

    @yield('css')
    @yield('js')

</head>

<body>


    <main>


        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap" />
                </svg>
                <span class="fs-4">功能選單 </span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a id="center" href="{{route('admin.center')}}" class="nav-link text-white" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a id="news" href="{{route('admin.news')}}" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#speedometer2" />
                        </svg>
                        最新消息
                    </a>
                </li>
                <li class="nav-item">
                    <a id="orders" href="{{route('admin.orders')}}" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#table" />
                        </svg>
                        訂單
                    </a>
                </li>
                <li class="nav-item">
                    <a id="products" href="{{route('admin.products')}}" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#grid" />
                        </svg>
                        產品
                    </a>
                </li>
                <li class="nav-item">
                    <a id="users" href="{{route('admin.users')}}" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#people-circle" />
                        </svg>
                        用戶
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

                    <strong>管理員 : {{Auth::user()->name}}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="{{route('home')}}">訪客首頁</a></li>
                    <li><a class="dropdown-item" href="{{route('user.profile')}}">個人檔案</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{route('logout')}}">登出</a></li>
                </ul>
            </div>
        </div>

        <div class="b-example-divider"></div>

        <div class="col-9" style="overflow: auto">
            @yield('content')
        </div>





    </main>


    <script src="{{asset('adminSideBar/assets/dist/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('adminSideBar/sidebars/sidebars.js')}}"></script>
</body>

</html>