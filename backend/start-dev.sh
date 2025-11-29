#!/bin/bash

# Install dependencies if needed
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install
fi

if [ ! -d "node_modules" ]; then
    echo "Installing NPM dependencies..."
    npm install
fi

# Start PHP server in background
echo "Starting PHP development server..."
php artisan serve --host=0.0.0.0 --port=8000 &
PHP_PID=$!

# Start Vite dev server in background
echo "Starting Vite development server..."
npm run dev &
VITE_PID=$!

# Function to handle shutdown
cleanup() {
    echo "Shutting down servers..."
    kill $PHP_PID $VITE_PID 2>/dev/null
    exit 0
}

# Trap signals to cleanup
trap cleanup SIGTERM SIGINT

# Wait for both processes
wait
