# LibraryHub - Library Management Platform

A modern library management platform built with Symfony 8.0, providing online access for users, librarians, and administrators.

NOTE : This is a school project an as such any content inside holds no real world values other than to show an example of what I can do.

## Requirements

- PHP 8.4+
- Composer
- Docker & Docker Compose (for PostgreSQL and Mailpit)

## Getting Started

```bash
# 1. Start the database and mailer containers
docker compose up -d

# 2. Install dependencies
composer install

# 3. Create the database and run migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 4. Start the Symfony development server
symfony serve
```

The application will be available at `http://localhost:8000`.

## Loading Test Fixtures

IMPORTANT : THIS WILL WIPE ALL ROWS INSIDE THE DATABASE.

The file `fixtures.sql` populates the database with sample data for testing purposes (users, authors, books, categories, languages, reservations, and reviews).

```bash
# On Windows (PowerShell)
Get-Content fixtures.sql | docker exec -i dsp4_tp_synfony-database-1 psql -U app -d app

# On Linux / macOS
cat fixtures.sql | docker exec -i dsp4_tp_synfony-database-1 psql -U app -d app
```

This creates the following test accounts (password for all: `123456789`):

| Email | Role |
| - | - |
| basic@user.com | ROLE_USER |
| librarian@user.com | ROLE_LIBRARIAN |
| administrator@user.com | ROLE_ADMIN |

It also seeds 8 authors, 8 categories, 10 books, 2 languages (English & French), 4 reservations, and 3 reviews.

## Running Tests

```bash
# Create the test database
php bin/console --env=test doctrine:database:create --if-not-exists
php bin/console --env=test doctrine:schema:create

# Run all tests
php bin/phpunit
```

## Roles

| Role | Description |
| - | - |
| `ROLE_USER` | Default role. Can search books, reserve, favorite, review. |
| `ROLE_LIBRARIAN` | Inherits ROLE_USER. Can manage the catalog and view history. |
| `ROLE_ADMIN` | Inherits ROLE_LIBRARIAN. Full access including user and review management. |

## Entities

| Entity | Columns |
| - | - |
| **User** | id, email (unique), password, firstName, lastName, roles (json), favoriteBooks (ManyToMany → Book) |
| **Book** | id, title, description, isbn (unique), publicationDate, pageCount, coverImage, stockQuantity, language (ManyToOne → Language), authors (ManyToMany → Author), categories (ManyToMany → Category) |
| **Author** | id, firstName, lastName, biography |
| **Category** | id, name (unique) |
| **Language** | id, name (unique), code (unique) |
| **Reservation** | id, startDate, endDate, status (enum: pending, confirmed, returned, cancelled), createdAt, borrower (ManyToOne → User), book (ManyToOne → Book) |
| **Review** | id, rating (1–5), comment, createdAt, reviewer (ManyToOne → User), book (ManyToOne → Book) |