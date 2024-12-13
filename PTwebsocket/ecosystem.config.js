module.exports = {
  apps: [
    {
      name: 'casino-server',
      script: 'Server.js',
      watch: true,
      env: {
        NODE_ENV: 'production'
      },
      error_file: './logs/server-error.log',
      out_file: './logs/server-out.log',
      time: true
    },
    {
      name: 'casino-slots',
      script: 'Slots.js',
      watch: true,
      env: {
        NODE_ENV: 'production'
      },
      error_file: './logs/slots-error.log',
      out_file: './logs/slots-out.log',
      time: true
    },
    {
      name: 'casino-arcade',
      script: 'Arcade.js',
      watch: true,
      env: {
        NODE_ENV: 'production'
      },
      error_file: './logs/arcade-error.log',
      out_file: './logs/arcade-out.log',
      time: true
    }
  ]
}; 