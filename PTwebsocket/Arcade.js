const WebSocket = require('ws');
const fs = require('fs');
const https = require('https');
const config = require('./arcade_config.json');

// SSL Configuration
const ssl_options = {
    cert: fs.readFileSync('./ssl/crt.crt'),
    key: fs.readFileSync('./ssl/key.key')
};

// Game state management
const activeArcadeGames = new Map();
const supportedGames = ['fish', 'shooter', 'racing'];

// Create HTTPS server
const server = https.createServer(ssl_options);
const wss = new WebSocket.Server({ server });

// Connection handling
wss.on('connection', (ws, req) => {
    console.log('New arcade client connected');
    
    // Assign unique session ID
    ws.sessionId = Date.now().toString();
    
    ws.send(JSON.stringify({
        type: 'welcome',
        sessionId: ws.sessionId,
        supportedGames,
        message: 'Connected to arcade server'
    }));

    // Handle incoming messages
    ws.on('message', (message) => {
        try {
            const data = JSON.parse(message);
            handleArcadeMessage(ws, data);
        } catch (error) {
            console.error('Error processing arcade message:', error);
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Invalid message format'
            }));
        }
    });

    // Handle disconnection
    ws.on('close', () => {
        console.log(`Arcade client ${ws.sessionId} disconnected`);
        cleanupArcadeGame(ws.sessionId);
    });
});

// Message handler for arcade games
function handleArcadeMessage(ws, data) {
    switch (data.type) {
        case 'start_game':
            startArcadeGame(ws, data);
            break;
            
        case 'game_action':
            handleGameAction(ws, data);
            break;
            
        case 'end_game':
            endArcadeGame(ws, data);
            break;
            
        default:
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Unknown arcade action'
            }));
    }
}

// Start new arcade game session
function startArcadeGame(ws, data) {
    if (!supportedGames.includes(data.gameType)) {
        return ws.send(JSON.stringify({
            type: 'error',
            message: 'Unsupported game type'
        }));
    }

    const gameState = {
        gameType: data.gameType,
        balance: data.balance || 1000,
        score: 0,
        level: 1,
        startTime: Date.now()
    };
    
    activeArcadeGames.set(ws.sessionId, gameState);
    
    ws.send(JSON.stringify({
        type: 'game_started',
        gameState
    }));
}

// Handle game actions
function handleGameAction(ws, data) {
    const gameState = activeArcadeGames.get(ws.sessionId);
    if (!gameState) {
        return ws.send(JSON.stringify({
            type: 'error',
            message: 'Game not started'
        }));
    }
    
    // Process game-specific actions
    switch (gameState.gameType) {
        case 'fish':
            handleFishGameAction(ws, gameState, data);
            break;
            
        case 'shooter':
            handleShooterGameAction(ws, gameState, data);
            break;
            
        case 'racing':
            handleRacingGameAction(ws, gameState, data);
            break;
    }
}

// Fish game action handler
function handleFishGameAction(ws, gameState, data) {
    switch (data.action) {
        case 'shoot':
            const hit = Math.random() < 0.4;  // 40% chance to hit
            const points = hit ? Math.floor(Math.random() * 100) : 0;
            gameState.score += points;
            
            ws.send(JSON.stringify({
                type: 'action_result',
                hit,
                points,
                gameState
            }));
            break;
            
        default:
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Invalid fish game action'
            }));
    }
    
    activeArcadeGames.set(ws.sessionId, gameState);
}

// Shooter game action handler
function handleShooterGameAction(ws, gameState, data) {
    switch (data.action) {
        case 'fire':
            const accuracy = Math.random();
            const damage = Math.floor(accuracy * 100);
            gameState.score += damage;
            
            ws.send(JSON.stringify({
                type: 'action_result',
                accuracy,
                damage,
                gameState
            }));
            break;
            
        default:
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Invalid shooter game action'
            }));
    }
    
    activeArcadeGames.set(ws.sessionId, gameState);
}

// Racing game action handler
function handleRacingGameAction(ws, gameState, data) {
    switch (data.action) {
        case 'move':
            const speed = data.speed || 1;
            const position = calculateNewPosition(data);
            gameState.score += speed;
            
            ws.send(JSON.stringify({
                type: 'action_result',
                position,
                speed,
                gameState
            }));
            break;
            
        default:
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Invalid racing game action'
            }));
    }
    
    activeArcadeGames.set(ws.sessionId, gameState);
}

// Calculate new position for racing game
function calculateNewPosition(data) {
    // TODO: Implement proper position calculation
    return {
        x: Math.random() * 100,
        y: Math.random() * 100
    };
}

// End arcade game session
function endArcadeGame(ws, data) {
    const gameState = activeArcadeGames.get(ws.sessionId);
    if (!gameState) {
        return ws.send(JSON.stringify({
            type: 'error',
            message: 'No active game'
        }));
    }
    
    const finalScore = gameState.score;
    const duration = Date.now() - gameState.startTime;
    
    ws.send(JSON.stringify({
        type: 'game_ended',
        finalScore,
        duration,
        gameState
    }));
    
    cleanupArcadeGame(ws.sessionId);
}

// Cleanup arcade game session
function cleanupArcadeGame(sessionId) {
    activeArcadeGames.delete(sessionId);
}

// Start the server
const port = parseInt(config.port);
server.listen(port, () => {
    console.log(`Arcade server running on port ${port}`);
}); 