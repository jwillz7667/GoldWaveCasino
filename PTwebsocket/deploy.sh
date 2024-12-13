#!/bin/bash

# Update system
echo "Updating system..."
sudo apt update && sudo apt upgrade -y

# Install Node.js and npm
echo "Installing Node.js and npm..."
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Install PM2 globally
echo "Installing PM2..."
sudo npm install -g pm2

# Create logs directory
echo "Creating logs directory..."
mkdir -p logs

# Install dependencies
echo "Installing dependencies..."
npm install

# Setup SSL directory
echo "Setting up SSL directory..."
mkdir -p ssl
chmod 700 ssl

# Copy SSL certificates (you'll need to upload these separately)
echo "Please upload SSL certificates to the ssl directory:"
echo "- ssl/crt.crt"
echo "- ssl/key.key"

# Start the servers
echo "Starting servers..."
pm2 start ecosystem.config.js

# Save PM2 configuration
echo "Saving PM2 configuration..."
pm2 save

# Setup PM2 to start on boot
echo "Setting up PM2 startup..."
pm2 startup

echo "Deployment complete!"
echo "Don't forget to:"
echo "1. Upload SSL certificates"
echo "2. Configure .env file"
echo "3. Set up firewall rules for ports 443, 8443, and 8444" 