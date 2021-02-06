<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Lorem</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="order">Заказы</a>
            </li>
            @if($user_group === 'manager' || $user_group === 'global')
                <li class="nav-item active">
                    <a class="nav-link" href="manager">Панель менеджера</a>
                </li>
            @else
            @endif
            @if($user_group === 'admin' || $user_group === 'global')
                <li class="nav-item active">
                    <a class="nav-link" href="admin">Управление товарами</a>
                </li>
            @else
            @endif
            @if($user_group === 'global')
                <li class="nav-item active">
                    <a class="nav-link" href="global">Управление администраторами</a>
                </li>
            @else
            @endif
        </ul>
        @if($user_email !== 'guest')
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link nav-light-link" href="refill">0,00 <b>₽</b></a>
                </li>
                <li class="nav-item active dropdown dropleft">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $user_email }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Настройки профиля</a>
                        <a class="dropdown-item" href="#">История покупок</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="logout">Выйти</a>
                </li>
            </ul>
        @else
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="register">Регистрация</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="login">Вход</a>
                </li>
            </ul>
        @endif
    </div>
</nav>
