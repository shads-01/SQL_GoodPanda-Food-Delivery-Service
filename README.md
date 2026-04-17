# 🐼 GoodPanda — Food Delivery Management System

A full-stack food delivery platform built as a database design project. We modeled the complete lifecycle of a service like FoodPanda — customer registration, restaurant browsing, menu management, cart, checkout, payment, delivery tracking, and reviews — all powered by raw SQL on Microsoft SQL Server.

> **CSE 3104: Database Lab** · Spring 2025 · Ahsanullah University of Science and Technology

---

## 👨‍💻 Team

| Name                    | Student ID  |
| ----------------------- | ----------- |
| Samia Rahman Arpita     | 20230104007 |
| Kazi Md. Shahadat Hasan | 20230104008 |
| Hrittika Saha           | 20230104024 |

---

## ✨ Features

### Customer Side
- Browse restaurants by cuisine, rating, and search
- View restaurant menus with category & cuisine filters, pagination
- Add-to-cart with live quantity management (AJAX)
- Full checkout flow with address selection and offer application
- Order history with review & rating submission
- Profile management with multiple saved addresses
- Soft account deletion (keeps data integrity, frees up credentials)

### Restaurant Owner Side
- Dashboard with real-time stats — revenue, orders, top items
- Menu management — add, edit, delete items with categories and images
- Order management — view and update order status live
- Offer system — create/edit percentage & flat discounts on items
- Review monitoring

### Delivery Rider Side
- Available deliveries feed with restaurant and customer info
- Accept, pick up, and deliver flow with status tracking
- Delivery history with earnings overview
- Profile and vehicle management

---

## 🛠️ Tech Stack

| Layer    | Technology                        |
| -------- | --------------------------------- |
| Backend  | Laravel 12 · PHP 8.3              |
| Frontend | Livewire 3 · Blade · Tailwind CSS |
| Database | Microsoft SQL Server 2022          |
| Server   | Nginx · Docker                     |
| Build    | Vite · Node.js 20                  |

---

## 🗄️ Database Overview

**18 core tables** modeling the full food delivery pipeline:

```
Register → Browse Restaurants → View Menu → Add to Cart → Place Order → Pay → Deliver → Review
```

| Area        | Tables |
|-------------|--------|
| Users & Auth | `users`, `customer_profiles`, `customer_addresses`, `restaurant_owner_profiles`, `delivery_partner_profiles` |
| Restaurants | `restaurants`, `cuisine_types`, `restaurant_cuisines`, `restaurant_ratings`, `menu_categories`, `menu_items` |
| Orders      | `cart`, `cart_items`, `orders`, `payments`, `offers` |
| Delivery    | `deliveries` |
| Feedback    | `reviews` |

### SQL Features Used
- **Stored Procedures** — cart management, order placement, restaurant details, menu search
- **Views** — customer profiles, restaurant/cuisine listings
- **Triggers** — audit logging on account deactivation
- **Transactions** — atomic order placement with rollback on failure
- **Subqueries** — top offers, aggregated restaurant rankings
- **Aggregate Functions** — AVG ratings, COUNT reviews, SUM revenue
- **JOINs** — LEFT, INNER, multi-table across all query files
- **CHECK Constraints** — email format, phone pattern, rating bounds, enum validation

---

## 🚀 Setup & Run

### Prerequisites
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/)
- [SQL Server Management Studio (SSMS)](https://learn.microsoft.com/en-us/sql/ssms/download-sql-server-management-studio-ssms)

### 1. Clone and configure

```bash
git clone https://github.com/YOUR_USERNAME/goodpanda.git
cd goodpanda
cp .env.example .env
```

### 2. Start Docker containers

```bash
docker compose build
docker compose up -d
```

This starts three containers:
- `goodpanda_app` — PHP 8.3 FPM (Laravel)
- `goodpanda_nginx` — Web server at **http://localhost:8080**
- `goodpanda_sqlserver` — SQL Server 2022 at **localhost:1433**

### 3. Install dependencies & generate key

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

### 4. Connect to the database via SSMS

| Field                    | Value                     |
| ------------------------ | ------------------------- |
| Server type              | Database Engine           |
| Server name              | `localhost,1433`          |
| Authentication           | SQL Server Authentication |
| Login                    | `sa`                      |
| Password                 | `GoodPanda@2025!`         |
| Encrypt                  | Optional                  |
| Trust server certificate | ✅ Check this box         |

### 5. Run SQL scripts in SSMS

Open and execute the following files **in order**:

```
1. database/sql/schema/00_all_tables.sql        → Creates all 18 tables
2. database/sql/procedures/*.sql                 → Creates stored procedures
3. database/sql/views/*.sql                      → Creates views
4. database/sql/queries/customer/trg_soft_delete_account.sql  → Creates trigger
5. database/sql/seed/00_seed_all_tables.sql      → Populates sample data
```

> **Tip:** Run each file one at a time in a new SSMS query window connected to `goodpanda_db`.

### 6. Launch the app

```bash
npm install
npm run dev          # Start Vite (separate terminal)
```

Open **http://localhost:8080** in your browser. Default login password for all seeded accounts is `password`.

---

## 🔁 Daily Workflow

```bash
docker compose up -d       # Start containers
npm run dev                # Hot-reload CSS/JS (separate terminal)
docker compose down        # Stop everything
```

---

## 🔐 Environment Variables

| Variable        | Value (Docker)     | Value (SSMS)       |
| --------------- | ------------------ | ------------------ |
| `DB_HOST`       | `sqlserver`        | `localhost,1433`   |
| `DB_PORT`       | `1433`             | `1433`             |
| `DB_DATABASE`   | `goodpanda_db`     | `goodpanda_db`     |
| `DB_USERNAME`   | `sa`               | `sa`               |
| `DB_PASSWORD`   | `GoodPanda@2025!`  | `GoodPanda@2025!`  |

---

*Built with ☕ and SQL queries — Spring 2025*
