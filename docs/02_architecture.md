# Architecture

## Overview

The application follows a simple, minimal architecture using native PHP with light structuring.

No framework is used to keep the implementation transparent and focused.

---

## High-Level Flow

1. User opens the application
2. Application loads API credentials from `.env` (or input)
3. User views list of contact lists
4. User selects a list
5. Application fetches first 20 subscribers
6. User applies filtering or sorting
7. Results are displayed

---

## Application Structure

```
/app
  /public
    index.php
  /src
    Api/
    Controller/
    Service/
    View/
  /config
  /vendor
```

---

## Key Components

### 1. Entry Point

* `public/index.php`
* Handles routing (basic, no framework)

### 2. Router (Simple)

* Query-param based routing (e.g. `?page=lists`)
* No external routing library

### 3. API Client

* Handles communication with SalesAutopilot API
* Responsible for:

    * Authentication
    * Request building
    * Response parsing

### 4. Services

* Business logic layer
* Example:

    * ListService
    * SubscriberService

### 5. Views

* Simple PHP templates
* Server-side rendering
* No JS framework required

---

## Dependency Management

Using Composer for:

* `.env` handling (e.g. vlucas/phpdotenv)
* HTTP client (optional, e.g. Guzzle)

---

## Configuration

* Environment variables via `.env`
* Loaded at runtime
* Example:

    * API_USERNAME
    * API_PASSWORD

---

## Docker Setup

* PHP container (Apache or FPM)
* Optional:

    * Composer container (build step)

---

## Design Principles

* Keep it simple and readable
* Avoid over-engineering
* Explicit over implicit logic
* Isolate API logic from UI


## Routing Strategy (Explicit)

Routing is handled via a single entry point: `public/index.php`

### Supported routes (via GET parameter `page`):

* `?page=lists`

  * Displays all contact lists

* `?page=subscribers&list_id={id}`

  * Displays subscribers of selected list

### Optional query parameters:

* `sort`
* `filter`

### Default behavior:

* If no `page` is provided:

  * Redirect or fallback to `lists`

## Goal

Keep routing:

* Minimal
* Predictable
* Easy to debug
