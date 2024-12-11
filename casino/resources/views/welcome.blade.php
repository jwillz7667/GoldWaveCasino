<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    
    <!-- Styles -->
    <link href="/css/normalize.css" rel="stylesheet">
    <link href="/css/slick.css" rel="stylesheet">
    <link href="/css/simplebar.css" rel="stylesheet">
    <link href="/css/styles.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/simplebar.min.js"></script>
    <script src="/js/scripts.min.js" defer></script>
</head>
<body>
    <div class="page">
        <header class="header">
            <div class="header__container">
                <a href="/" class="logo">
                    <img src="/img/logo.png" alt="{{ config('app.name') }}" class="logo__img">
                </a>
                <nav class="nav">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="/" class="nav__link">Home</a>
                        </li>
                        <li class="nav__item">
                            <a href="/games" class="nav__link">Games</a>
                        </li>
                        @auth
                            <li class="nav__item">
                                <a href="/profile" class="nav__link">Profile</a>
                            </li>
                            <li class="nav__item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav__link nav__button">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav__item">
                                <a href="{{ route('login') }}" class="nav__link">Login</a>
                            </li>
                            <li class="nav__item">
                                <a href="{{ route('register') }}" class="nav__link nav__link--accent">Register</a>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main">
            <div class="main__container">
                @yield('content')
            </div>
        </main>

        <footer class="footer">
            <div class="footer__container">
                <div class="footer__content">
                    <div class="footer__logo">
                        <img src="/img/logo.png" alt="{{ config('app.name') }}">
                    </div>
                    <div class="footer__links">
                        <a href="#" class="footer__link">About Us</a>
                        <a href="#" class="footer__link">Terms & Conditions</a>
                        <a href="#" class="footer__link">Privacy Policy</a>
                        <a href="#" class="footer__link">Contact</a>
                    </div>
                </div>
                <div class="footer__bottom">
                    <p class="footer__copyright">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
