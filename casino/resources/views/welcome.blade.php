<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a1c24 0%, #0f1015 100%);
            color: #fff;
            margin: 0;
            min-height: 100vh;
        }
        .header {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .hero {
            text-align: center;
            padding: 4rem 0;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/img/_tournament/Week.jpg');
            background-size: cover;
            background-position: center;
            margin-bottom: 2rem;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #aaa;
        }
        .game-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            padding: 1rem 0;
        }
        .game-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.3s ease;
            position: relative;
        }
        .game-card:hover {
            transform: translateY(-5px);
        }
        .game-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .game-info {
            padding: 1rem;
        }
        .game-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }
        .game-provider {
            color: #aaa;
            font-size: 0.9rem;
            margin: 0.5rem 0;
        }
        .play-button {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: opacity 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .play-button:hover {
            opacity: 0.9;
        }
        .category-tabs {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .category-tab {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.3s ease;
        }
        .category-tab.active {
            background: #4CAF50;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 4rem 0;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
        }
        .feature-card h3 {
            color: #4CAF50;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1 style="margin: 0;">{{ config('app.name') }}</h1>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="play-button">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="play-button">Login</a>
                        <a href="{{ route('register') }}" class="play-button">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div class="hero">
        <div class="container">
            <h1>Welcome to {{ config('app.name') }}</h1>
            <p>Experience the thrill of online gaming with our wide selection of games</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="play-button" style="width: auto; padding: 1rem 3rem;">Play Now</a>
            @else
                <a href="{{ route('register') }}" class="play-button" style="width: auto; padding: 1rem 3rem;">Join Now</a>
            @endauth
        </div>
    </div>

    <main class="container">
        <div class="category-tabs">
            <div class="category-tab active">Featured Games</div>
            <div class="category-tab">New Releases</div>
            <div class="category-tab">Popular</div>
            <div class="category-tab">Slots</div>
            <div class="category-tab">Live Casino</div>
        </div>

        <div class="game-grid">
            @foreach($slotGames as $game)
            <div class="game-card">
                <img src="{{ $game->image_url }}" alt="{{ $game->name }}" class="game-image">
                <div class="game-info">
                    <h3 class="game-title">{{ $game->name }}</h3>
                    <p class="game-provider">Provider Name</p>
                    @auth
                        <a href="/games/{{ $game->slug }}" class="play-button">Play Now</a>
                    @else
                        <a href="{{ route('register') }}" class="play-button">Join to Play</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        <div class="features">
            <div class="feature-card">
                <h3>Instant Withdrawals</h3>
                <p>Get your winnings instantly with our fast payout system</p>
            </div>
            <div class="feature-card">
                <h3>24/7 Support</h3>
                <p>Our support team is always here to help you</p>
            </div>
            <div class="feature-card">
                <h3>Secure Gaming</h3>
                <p>Play with confidence with our advanced security measures</p>
            </div>
        </div>
    </main>

    <script>
        // Add interactivity for category tabs
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelector('.category-tab.active').classList.remove('active');
                tab.classList.add('active');
            });
        });
    </script>
</body>
</html>
