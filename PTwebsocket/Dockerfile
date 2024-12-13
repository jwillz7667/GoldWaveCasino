FROM node:20-slim

# Create app directory
WORKDIR /usr/src/app

# Install PM2 globally
RUN npm install -g pm2

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy source code
COPY . .

# Create logs directory
RUN mkdir -p logs

# Create SSL directory and set permissions
RUN mkdir -p ssl && chmod 700 ssl

# Expose ports
EXPOSE 443 8443 8444

# Start the application using PM2
CMD ["pm2-runtime", "ecosystem.config.js"] 