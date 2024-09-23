<nav class="navbar navbar-expand bg-light-gray px-3">
    <a class="navbar-brand" href="/"><i class="fas fa-tint mr-2"></i>
        サウナクイズ
    </a>
    <ul class="navbar-nav ml-auto">
        @guest
        <li class="nav-item mr-3">
            <a class="nav-link" href="{{ route('register') }}">ユーザー登録</a>
        </li>
        @endguest
        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
        </li>
        @endguest
        <!-- Dropdown -->
        @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <button class="dropdown-item" type="button" onclick="location.href='{{ route('mypage.top') }}'"
                    method="post">
                    マイページ
                </button>
                <div class="dropdown-divider"></div>
                <button form="logout-button" class="dropdown-item" type="submit">
                    ログアウト
                </button>
            </div>
        </li>
        <form id="logout-button" method="POST" action="{{ route('logout') }}">
            @csrf
        </form>
        @endauth
        <!-- Dropdown -->
    </ul>
</nav>
