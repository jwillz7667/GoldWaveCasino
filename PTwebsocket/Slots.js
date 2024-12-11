const WebSocket = require('ws');
const fs = require('fs');
const https = require('https');
const config = require('./socket_config.json');

// SSL Configuration
const ssl_options = {
    cert: fs.readFileSync('./ssl/crt.crt'),
    key: fs.readFileSync('./ssl/key.key')
};

// Game state management
const activeGames = new Map();

// Create HTTPS server
const server = https.createServer(ssl_options);
const wss = new WebSocket.Server({ server });

// Connection handling
wss.on('connection', (ws, req) => {
    console.log('New slots client connected');
    
    // Assign unique session ID
    ws.sessionId = Date.now().toString();
    
    ws.send(JSON.stringify({
        type: 'welcome',
        sessionId: ws.sessionId,
        message: 'Connected to slots server'
    }));

    // Handle incoming messages
    ws.on('message', (message) => {
        try {
            const data = JSON.parse(message);
            handleSlotMessage(ws, data);
        } catch (error) {
            console.error('Error processing slot message:', error);
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Invalid message format'
            }));
        }
    });

    // Handle disconnection
    ws.on('close', () => {
        console.log(`Slots client ${ws.sessionId} disconnected`);
        cleanupGame(ws.sessionId);
    });
});

// Message handler for slot games
function handleSlotMessage(ws, data) {
    switch (data.type) {
        case 'init_game':
            initializeGame(ws, data);
            break;
            
        case 'spin':
            handleSpin(ws, data);
            break;
            
        case 'collect':
            handleCollect(ws, data);
            break;
            
        case 'gamble':
            handleGamble(ws, data);
            break;
            
        default:
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Unknown slot action'
            }));
    }
}

// Initialize new slot game session
function initializeGame(ws, data) {
    const gameState = {
        balance: data.balance || 1000,
        betAmount: data.betAmount || 1,
        lines: data.lines || 1,
        lastWin: 0
    };
    
    activeGames.set(ws.sessionId, gameState);
    
    ws.send(JSON.stringify({
        type: 'game_initialized',
        gameState
    }));
}

// Handle spin action
function handleSpin(ws, data) {
    const gameState = activeGames.get(ws.sessionId);
    if (!gameState) {
        return ws.send(JSON.stringify({
            type: 'error',
            message: 'Game not initialized'
        }));
    }
    
    // Deduct bet amount
    gameState.balance -= (gameState.betAmount * gameState.lines);
    
    // Generate spin result
    const result = generateSpinResult(gameState);
    
    // Update game state
    gameState.lastWin = result.totalWin;
    gameState.balance += result.totalWin;
    activeGames.set(ws.sessionId, gameState);
    
    ws.send(JSON.stringify({
        type: 'spin_result',
        result,
        gameState
    }));
}

// Generate random spin result
function generateSpinResult(gameState) {
    // TODO: Implement proper slot game logic
    const symbols = ['7', 'BAR', 'CHERRY', 'LEMON', 'ORANGE'];
    const reels = Array(5).fill().map(() => 
        Array(3).fill().map(() => 
            symbols[Math.floor(Math.random() * symbols.length)]
        )
    );
    
    // Simple win calculation
    const totalWin = Math.random() < 0.3 ? gameState.betAmount * Math.floor(Math.random() * 10) : 0;
    
    return {
        reels,
        totalWin,
        winLines: []  // TODO: Implement win line calculation
    };
}

// Handle collect action
function handleCollect(ws, data) {
    const gameState = activeGames.get(ws.sessionId);
    if (!gameState) {
        return ws.send(JSON.stringify({
            type: 'error',
            message: 'Game not initialized'
        }));
    }
    
    ws.send(JSON.stringify({
        type: 'collect_result',
        collected: gameState.lastWin,
        gameState
    }));
    
    gameState.lastWin = 0;
    activeGames.set(ws.sessionId, gameState);
}

// Handle gamble action
function handleGamble(ws, data) {
    const gameState = activeGames.get(ws.sessionId);
    if (!gameState || !gameState.lastWin) {
        return ws.send(JSON.stringify({
            type: 'error',
            message: 'No win to gamble'
        }));
    }
    
    // 50/50 chance to win gamble
    const won = Math.random() >= 0.5;
    if (won) {
        gameState.lastWin *= 2;
        gameState.balance += gameState.lastWin;
    } else {
        gameState.balance -= gameState.lastWin;
        gameState.lastWin = 0;
    }
    
    activeGames.set(ws.sessionId, gameState);
    
    ws.send(JSON.stringify({
        type: 'gamble_result',
        won,
        gameState
    }));
}

// Cleanup game session
function cleanupGame(sessionId) {
    activeGames.delete(sessionId);
}

// Start the server
const port = parseInt(config.port);
server.listen(port, () => {
    console.log(`Slots server running on port ${port}`);
}); 