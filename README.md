# SalesAutopilot API Test App

A simple PHP web application that integrates with the SalesAutopilot REST API. Built with native PHP, Guzzle, and Docker.

---

## Requirements

- [Docker](https://www.docker.com/) with Docker Compose

No other local dependencies are required.

---

## Setup

### 1. Clone the repository

```bash
git clone <repository-url>
cd SalesAutopilotApiTest
```

### 2. Configure environment variables

```bash
cp .env.example .env
```

Edit `.env` and fill in your SalesAutopilot API credentials:

```env
SAPI_USERNAME=your_api_username
SAPI_PASSWORD=your_api_password
SAPI_BASE_URL=https://api.salesautopilot.com
SAPI_TIMEOUT=10
```

You can find your API credentials in SalesAutopilot under:
**Settings → Integration → API Keys**

### 3. Start the application

```bash
docker compose up
```

The application will be available at: [http://localhost:8080](http://localhost:8080)

> **Note:** After changing `.env` values, restart the container with `docker compose restart` — no rebuild required.

---

## Usage

| Page | URL | Description |
|------|-----|-------------|
| List overview | `/?page=lists` | Displays all contact lists with name and size |
| Subscriber view | `/?page=subscribers&list_id={id}` | Shows the first 20 subscribers of a selected list |

### Filtering & Sorting

On the subscriber view, you can:
- **Filter** by email address (partial match, case-insensitive)
- **Sort** by email, first name, or subscription date

These are applied via URL parameters:
```
/?page=subscribers&list_id=12345&filter=example&sort=email
```

---

## Running Tests

A CLI smoke test script is included that covers all required error cases.

### Run the smoke tests

```bash
docker compose exec app php tests/smoke_test.php
```

### What is tested

| # | Test case |
|---|-----------|
| 1 | Valid credentials → fetch lists |
| 2 | Valid list ID → fetch up to 20 subscribers |
| 3 | List size retrieval via `listtotalcount` |
| 4 | Invalid credentials → 401 ApiException |
| 5 | Invalid list ID → graceful handling |
| 6 | Connection timeout → 503 ApiException |

### Expected output

```
== 1. Listák lekérése (valid credentials) ==
✔ PASS — getLists() tömböt ad vissza
✔ PASS — Lista tartalmaz id mezőt
...

== Eredmény ==
Összesen: 10 | 10 pass | 0 fail
```

---

## Project Structure

```
/
├── docker-compose.yml
├── Dockerfile
├── composer.json
├── .env.example
├── public/
│   └── index.php          # Entry point and router
├── src/
│   ├── Api/
│   │   ├── SalesAutopilotClient.php  # Guzzle-based API client
│   │   └── ApiException.php          # Custom exception
│   ├── Service/
│   │   ├── ListService.php           # List business logic
│   │   └── SubscriberService.php     # Subscriber filtering & sorting
│   └── View/
│       ├── layout.php                # HTML layout renderer
│       ├── lists.php                 # Lists view
│       ├── subscribers.php           # Subscribers view
│       └── error.php                 # Error view
├── tests/
│   └── smoke_test.php     # CLI smoke tests
├── docs/                  # Structured project documentation
├── V2_API_SPEC.md         # SalesAutopilot API reference summary
├── AI_LOG.md              # AI interaction log
└── REFLECTION.md          # Project reflection
```

---

## Error Handling

The application handles the following cases with user-friendly messages:

| Case | Behavior |
|------|----------|
| Missing or empty `.env` | Configuration error page |
| Invalid API credentials | 401 error message |
| Empty list (0 subscribers) | Informative empty state |
| API unreachable / timeout | 503 graceful degradation |
| Rate limit exceeded (429) | Retry message |

---

## Tech Stack

- **PHP 8.2** — stable, long-term support until end of 2026
- **Guzzle 7** — HTTP client for readable and maintainable API calls
- **vlucas/phpdotenv** — environment variable management
- **Apache** — web server via `php:8.2-apache` base image
- **Docker** — containerized runtime, single-command startup
