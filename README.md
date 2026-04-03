# GoodPanda — Food Delivery Management System

A database-driven food delivery platform built as a relational database design project. Models the complete order flow of a service like FoodPanda — from customer registration and menu browsing through to payment, delivery, and reviews.

> CSE 3104 Database Lab · Spring 2025 · Ahsanullah University of Science and Technology

---

## Team

| Name                    | Student ID  |
| ----------------------- | ----------- |
| Samia Rahman Arpita     | 20230104007 |
| Kazi Md. Shahadat Hasan | 20230104008 |
| Hrittika Saha           | 20230104024 |

---

## Stack

|          |                                  |
| -------- | -------------------------------- |
| Backend  | Laravel 12 · PHP 8.3             |
| Frontend | Livewire 3 · Tailwind CSS · Vite |
| Database | Microsoft SQL Server 2022        |
| Server   | Nginx · Docker                   |
| Testing  | Pest PHP                         |

---

## Database Design

The schema follows the real flow of a food delivery platform across **17 tables**:

```
Register → Browse Restaurants → View Menu → Add to Cart → Place Order → Pay → Delivery → Review
```

**Core tables:** `users` · `customer_addresses` · `restaurants` · `cuisine_types` · `restaurant_cuisines` · `restaurant_ratings` · `menu_categories` · `menu_items` · `cart` · `cart_items` · `orders` · `order_details` · `payments` · `delivery_partners` · `deliveries` · `reviews` · `item_reviews`

<!-- ERD -->
<!-- To add the ERD: export your diagram as a PNG, place it in docs/erd.png, then uncomment the line below -->
<!-- ![Entity Relationship Diagram](docs/erd.png) -->

All migrations are in `/database/migrations/` and run automatically on container start.

---

## Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/)
- [SSMS](https://learn.microsoft.com/en-us/sql/ssms/download-sql-server-management-studio-ssms) — to view and query the database

---

## First-Time Setup

### 1. Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/goodpanda.git
cd goodpanda
```

### 2. Copy the environment file

```bash
cp .env.example .env
```

> The `.env` file is **never committed to Git**. `.env.example` is the template.

### 3. Build and start Docker containers

```bash
docker compose build
docker compose up -d
```

This starts:

- `goodpanda_app` — PHP 8.3 FPM (your Laravel app)
- `goodpanda_nginx` — Web server on **http://localhost:8080**
- `goodpanda_sqlserver` — SQL Server 2022 on **localhost:1433**

### 4. Install PHP dependencies

```bash
docker compose exec app composer install
```

### 5. Generate the application key

```bash
docker compose exec app php artisan key:generate
```

### 6. Connect the database

Open SSMS and use these connection details:

| Field                    | Value                     |
| ------------------------ | ------------------------- |
| Server type              | Database Engine           |
| Server name              | `localhost,1433`          |
| Authentication           | SQL Server Authentication |
| Login                    | `sa`                      |
| Password                 | `GoodPanda@2025!`         |
| Encrypt                  | Optional                  |
| Trust server certificate | ✅ Check this box         |

### 7. Run migrations

Use SSMS to run SQL files from `database/sql` in this order:

```text
database/sql/schema/*.sql
database/sql/views/*.sql
database/sql/seed/*.sql
```

### 8. Open the app

Open in browser:
[http://localhost:8080](http://localhost:8080)

---

## Daily Development Workflow

```bash
# Start containers
docker compose up -d

# Start Vite for hot-reloading CSS/JS (separate terminal)
npm run dev

# Stop everything
docker compose down
```

---

## Project Structure

```
goodpanda/
├── app/
│   ├── Livewire/               # Livewire components
│   ├── Models/                 # Eloquent models
│   └── Http/Controllers/
├── database/
│   ├── migrations/             # Schema — runs automatically on startup
│   ├── seeders/
│   └── factories/
├── docker/
│   ├── nginx/default.conf
│   └── php/
│       ├── Dockerfile          # PHP 8.3 + Node.js 20 + MSSQL drivers
│       ├── entrypoint.sh       # Runs composer, npm build, migrate on start
│       └── php.ini
├── resources/views/            # Blade + Livewire templates
├── routes/
│   ├── web.php
│   └── auth.php
├── .env.example
├── docker-compose.yml
└── README.md
```

---

## Environment Variables

| Variable        | Value                                |
| --------------- | ------------------------------------ |
| `DB_CONNECTION` | `sqlsrv`                             |
| `DB_HOST`       | `sqlserver` ← use this inside Docker |
| `DB_PORT`       | `1433`                               |
| `DB_DATABASE`   | `goodpanda_db`                       |
| `DB_USERNAME`   | `sa`                                 |
| `DB_PASSWORD`   | `GoodPanda@2025!`                    |

> When connecting from SSMS on your machine use `localhost,1433`. Inside Docker containers use `sqlserver`.
