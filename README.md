# CoupleWatch

CoupleWatch is a real-time video watching application built with Laravel, Vue.js, and Reverb.

## Features

- **User Authentication**: Secure signup/login via Laravel Breeze.
- **Room Creation**: Create private rooms with YouTube videos.
- **Real-time Sync**: Synchronized video playback (play, pause, seek) across all users in a room.
- **Real-time Chat**: Instant messaging within rooms.
- **Responsive Design**: Mobile-friendly UI using Tailwind CSS.

## Tech Stack

- **Backend**: Laravel 11, MySQL, Redis, Laravel Reverb (WebSockets)
- **Frontend**: Vue.js 3, Inertia.js, Tailwind CSS
- **DevOps**: Docker, Nginx

## Setup Instructions

### Prerequisites

- Docker & Docker Compose
- Node.js & NPM
- PHP 8.2+ (optional if using Docker for everything)

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd couple-watch-app
   ```

2. **Environment Setup**
   Copy the example environment file and configure it:
   ```bash
   cp .env.example .env
   ```
   Ensure the following variables are set for Reverb:
   ```ini
   BROADCAST_CONNECTION=reverb
   REVERB_APP_ID=10000
   REVERB_APP_KEY=couplewatchkey
   REVERB_APP_SECRET=couplewatchsecret
   REVERB_HOST="localhost"
   REVERB_PORT=8080
   REVERB_SCHEME=http

   VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
   VITE_REVERB_HOST="${REVERB_HOST}"
   VITE_REVERB_PORT="${REVERB_PORT}"
   VITE_REVERB_SCHEME="${REVERB_SCHEME}"
   ```

3. **Start Docker Containers**
   ```bash
   docker compose up -d
   ```

4. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

5. **Generate Key & Migrate**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

### Running the Application

To run the application locally with real-time features, you need to run the following commands in separate terminal windows:

1. **Start Reverb (WebSocket Server)**
   ```bash
   php artisan reverb:start
   ```

2. **Start Queue Worker (for events)**
   ```bash
   php artisan queue:listen
   ```

3. **Start Vite (for frontend HMR)**
   ```bash
   npm run dev
   ```

4. **Serve Application**
   If not using Nginx via Docker:
   ```bash
   php artisan serve
   ```
   Access the app at `http://localhost:8000`.

## Testing

Run the test suite:
```bash
php artisan test
```

## License

MIT
