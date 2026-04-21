# Decisions

## 1. Use of Native PHP (No Framework)

The application is implemented using native PHP instead of a framework.

### Reasoning:

* Keeps the solution lightweight and transparent
* Avoids unnecessary abstraction for a small task
* Demonstrates understanding of core PHP concepts

---

## 2. Use of Composer Packages

Composer is used to simplify development.

### Selected tools:

* `vlucas/phpdotenv` for environment variable handling
* Optional HTTP client (e.g. Guzzle)

### Reasoning:

* Avoid reinventing common functionality
* Keep focus on core logic

---

## 3. Filtering and Sorting Implementation

Filtering and sorting are implemented using query parameters (GET).

### Example:

* `?sort=email`
* `?sort=created_at`
* `?filter=email_contains=test`

### Reasoning:

* Simple and transparent
* No need for JavaScript
* Easy to debug and extend

---

## 4. In-Memory Data Processing

Filtering and sorting are applied after fetching data from the API.

### Reasoning:

* Avoid dependency on API capabilities
* Keeps logic under full control
* Suitable for small datasets (20 items)

---

## 5. Minimal UI Approach

The UI is server-rendered using plain PHP templates.

### Reasoning:

* Meets requirements without overengineering
* Focus remains on backend/API integration

---

## 6. Dockerized Environment

The application runs entirely in Docker.

### Reasoning:

* Ensures reproducibility
* Matches task requirements
* Simplifies setup

---

## 7. No Database Usage

No database is used.

### Reasoning:

* Not required by the task
* Avoids unnecessary complexity

---

## 8. Error Handling Strategy

Errors are handled gracefully and shown to the user.

### Reasoning:

* Requirement explicitly demands it
* Improves usability and robustness

---

## 9. API Isolation

All API logic is encapsulated in a dedicated client.

### Reasoning:

* Improves maintainability
* Simplifies debugging
* Enables future extension
