# video-management-platform
A lightweight Laravel + Vue 3 (Vuetify) Prototype video management and analytics system inspired
# Demo

### Features
- Upload video → async “transcode” job via Laravel Queue (Redis)
- Track status transitions (UPLOADED → PROCESSING → READY/FAILED)
- Serve video assets via Nginx storage alias
- Record play events and aggregate Top Videos analytics
- Fully containerized with Docker + Traefik
- Live Vue dashboard (upload, listing, analytics)
