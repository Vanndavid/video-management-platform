#  Video Management Platform  

A lightweight Laravel + Vue 3 (Vuetify) Prototype video management and analytics system inspired
---

##  Overview

| Layer | Technology | Purpose |
|-------|-------------|----------|
| **Backend API** | Laravel 11 (API-only) | Video upload, queue jobs, analytics |
| **Frontend** | Vue 3 + Vuetify | Simple dashboard for upload & listing |
| **Queue** | Redis 7 + Laravel Queue | Simulated transcoding jobs |
| **Database** | SQLite | Store listings, videos, assets, events |
| **Reverse Proxy** | Traefik v3 | HTTPS routing for frontend + API |
| **Runtime** | Docker Compose | Local + server environment parity |

---

##  Features

-  **Video Uploads** — Upload MP4/WebM files per listing  
-  **Async Job Flow** — Queues a fake *TranscodeVideoJob* that simulates processing  
-  **Status Tracking** — `UPLOADED → PROCESSING → READY / FAILED`  
-  **Asset Management** — Stores original videos and mock renditions in `/storage/app/public/videos`  
-  **Playback Analytics** — Tracks play/completion events and returns top-played videos  
-  **Vue Dashboard** — View listings, upload new videos, and see analytics summary  
-  **Containerized Stack** — Laravel + Vue + Redis + Traefik in one Docker Compose setup

---

##  Testing

Feature tests verify:
- `/api/health` endpoint responds with ✅ 200 OK  
- `/api/videos` creates a new record and dispatches a queue job  

---

##  Run Locally

1. Copy env file
cp .env.example .env

2. Start containers
docker compose -f docker-compose.dev.yml up -d --build

3. Migrate database
docker compose exec app php artisan migrate --seed

Then open:
Frontend: http://video.localhost
API: http://video.localhost/api/health

---

## Design Highlights

Clean RESTful API with Laravel Resources

Simple async queue design using Redis

Developer-friendly Dockerized setup

Focus on backend architecture, not UI polish

---

## Future Improvements

Real FFmpeg-based transcoding service

S3 or cloud storage integration

Horizon dashboard for monitoring jobs

Authenticated users and access control

Analytics visualizations and filters

## Author

Vanndavid Teng

🌐 vanndavidteng.com