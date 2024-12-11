<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Slot Games
        $slotGames = [
            [
                'name' => 'Lucky 7s',
                'slug' => 'lucky-7s',
                'type' => 'slot',
                'description' => 'Classic slot game with lucky number 7s',
                'min_bet' => 0.10,
                'max_bet' => 100.00,
                'image_url' => '/images/games/slots/lucky-7s.jpg',
                'settings' => [
                    'reels' => 5,
                    'rows' => 3,
                    'lines' => 20,
                    'symbols' => ['7', 'BAR', 'CHERRY', 'LEMON', 'ORANGE']
                ]
            ],
            [
                'name' => 'Fruit Fiesta',
                'slug' => 'fruit-fiesta',
                'type' => 'slot',
                'description' => 'Colorful fruit-themed slot game',
                'min_bet' => 0.20,
                'max_bet' => 200.00,
                'image_url' => '/images/games/slots/fruit-fiesta.jpg',
                'settings' => [
                    'reels' => 5,
                    'rows' => 3,
                    'lines' => 25,
                    'symbols' => ['WILD', 'SCATTER', 'APPLE', 'BANANA', 'ORANGE', 'GRAPE']
                ]
            ]
        ];

        // Arcade Games
        $arcadeGames = [
            [
                'name' => 'Fish Hunter',
                'slug' => 'fish-hunter',
                'type' => 'arcade',
                'description' => 'Catch fish and win prizes',
                'min_bet' => 1.00,
                'max_bet' => 500.00,
                'image_url' => '/images/games/arcade/fish-hunter.jpg',
                'settings' => [
                    'fish_types' => [
                        'small' => ['points' => 10, 'speed' => 1.5],
                        'medium' => ['points' => 30, 'speed' => 1.0],
                        'large' => ['points' => 50, 'speed' => 0.7],
                        'boss' => ['points' => 100, 'speed' => 0.5]
                    ]
                ]
            ],
            [
                'name' => 'Space Shooter',
                'slug' => 'space-shooter',
                'type' => 'arcade',
                'description' => 'Shoot aliens and collect rewards',
                'min_bet' => 0.50,
                'max_bet' => 250.00,
                'image_url' => '/images/games/arcade/space-shooter.jpg',
                'settings' => [
                    'enemy_types' => [
                        'drone' => ['points' => 5, 'health' => 1],
                        'fighter' => ['points' => 15, 'health' => 2],
                        'bomber' => ['points' => 25, 'health' => 3],
                        'boss' => ['points' => 100, 'health' => 10]
                    ]
                ]
            ],
            [
                'name' => 'Racing Stars',
                'slug' => 'racing-stars',
                'type' => 'arcade',
                'description' => 'Race against opponents and win big',
                'min_bet' => 1.00,
                'max_bet' => 300.00,
                'image_url' => '/images/games/arcade/racing-stars.jpg',
                'settings' => [
                    'tracks' => [
                        'easy' => ['multiplier' => 1.2, 'obstacles' => 5],
                        'medium' => ['multiplier' => 1.5, 'obstacles' => 10],
                        'hard' => ['multiplier' => 2.0, 'obstacles' => 15]
                    ]
                ]
            ]
        ];

        // Insert all games
        foreach (array_merge($slotGames, $arcadeGames) as $game) {
            Game::create($game);
        }
    }
} 