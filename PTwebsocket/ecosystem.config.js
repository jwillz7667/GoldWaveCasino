module.exports = {
  apps: [
    {
      name: 'casino-server',
      script: 'Server.js',
      watch: true,
      env: {
        NODE_ENV: 'production'
      }
    },
    {
      name: 'casino-slots',
      script: 'Slots.js',
      watch: true,
      env: {
        NODE_ENV: 'production'
      }
    },
    {
      name: 'casino-arcade',
      script: 'Arcade.js',
      watch: true,
      env: {
        NODE_ENV: 'production'
      }
    }
  ]
}; 