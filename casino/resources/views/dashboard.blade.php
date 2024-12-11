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
        .balance-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1rem 0;
        }
        .balance-amount {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffd700;
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
        .search-bar {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
            width: 100%;
            max-width: 400px;
            color: white;
            margin: 1rem 0;
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
                        <span>{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="play-button" style="padding: 0.5rem 1rem;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="play-button" style="text-decoration: none;">Login</a>
                        <a href="{{ route('register') }}" class="play-button" style="text-decoration: none;">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        @auth
        <div class="balance-card">
            <div>
                <div style="color: #aaa;">Balance</div>
                <div class="balance-amount">${{ number_format(auth()->user()->balance ?? 0, 2) }}</div>
            </div>
            <button class="play-button" style="width: auto;">Add Funds</button>
        </div>
        @endauth

        <input type="search" class="search-bar" placeholder="Search games...">

        <div class="category-tabs">
            <div class="category-tab active">All Games</div>
            <div class="category-tab">Slots</div>
            <div class="category-tab">Live Casino</div>
            <div class="category-tab">Table Games</div>
            <div class="category-tab">New Games</div>
            <div class="category-tab">Popular</div>
        </div>

        <div class="game-grid">
            @foreach($slotGames as $game)
            <div class="game-card">
                <img src="{{ $game->image_url }}" alt="{{ $game->name }}" class="game-image">
                <div class="game-info">
                    <h3 class="game-title">{{ $game->name }}</h3>
                    <p class="game-provider">Provider Name</p>
                    <button class="play-button">Play Now</button>
                </div>
            </div>
            @endforeach

            @foreach($arcadeGames as $game)
            <div class="game-card">
                <img src="{{ $game->image_url }}" alt="{{ $game->name }}" class="game-image">
                <div class="game-info">
                    <h3 class="game-title">{{ $game->name }}</h3>
                    <p class="game-provider">Provider Name</p>
                    <button class="play-button">Play Now</button>
                </div>
            </div>
            @endforeach
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
