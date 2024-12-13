require('dotenv').config();
const WebSocket = require('ws');
const fs = require('fs');
const https = require('https');

// SSL Configuration
const ssl_options = {
    cert: fs.readFileSync(process.env.SSL_CERT_PATH),
    key: fs.readFileSync(process.env.SSL_KEY_PATH)
};

// Create HTTPS server
const server = https.createServer(ssl_options);
const wss = new WebSocket.Server({ server });

// Connection handling
wss.on('connection', (ws, req) => {
    console.log('New client connected');
    
    // Send welcome message
    ws.send(JSON.stringify({
        type: 'welcome',
        message: 'Connected to game server'
    }));

    // Handle incoming messages
    ws.on('message', (message) => {
        try {
            const data = JSON.parse(message);
            handleMessage(ws, data);
        } catch (error) {
            console.error('Error processing message:', error);
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Invalid message format'
            }));
        }
    });

    // Handle client disconnection
    ws.on('close', () => {
        console.log('Client disconnected');
    });

    // Handle errors
    ws.on('error', (error) => {
        console.error('WebSocket error:', error);
    });
});

// Message handler
function handleMessage(ws, data) {
    switch (data.type) {
        case 'ping':
            ws.send(JSON.stringify({
                type: 'pong',
                timestamp: Date.now()
            }));
            break;
            
        case 'auth':
            // Handle authentication
            handleAuth(ws, data);
            break;
            
        case 'game_action':
            // Handle game actions
            handleGameAction(ws, data);
            break;
            
        default:
            ws.send(JSON.stringify({
                type: 'error',
                message: 'Unknown message type'
            }));
    }
}

// Authentication handler
function handleAuth(ws, data) {
    // TODO: Implement proper authentication
    ws.send(JSON.stringify({
        type: 'auth_response',
        success: true,
        message: 'Authentication successful'
    }));
}

// Game action handler
function handleGameAction(ws, data) {
    // TODO: Implement game action handling
    ws.send(JSON.stringify({
        type: 'game_response',
        action: data.action,
        success: true
    }));
}

// Start the server
const port = parseInt(process.env.MAIN_PORT);
server.listen(port, () => {
    console.log(`Server running on port ${port}`);
}); 