# API Integration

## Overview

The application integrates with the SalesAutopilot REST API to retrieve:

* Contact lists
* Subscribers of a selected list

Since the API is external and partially unknown, the integration is designed to be:

* Isolated
* Replaceable
* Easy to debug

---

## Authentication

The API uses basic authentication with:

* Username
* Password

Credentials are loaded from:

* `.env` file (primary)
* Optional user input (fallback)

---

## API Client Design

A dedicated API client is responsible for all HTTP communication.

### Responsibilities:

* Build HTTP requests
* Attach authentication headers
* Handle responses
* Normalize data format

---

## Suggested Implementation

### HTTP Client

* Use Guzzle (via Composer) OR native cURL
* Guzzle preferred for simplicity and readability

### Base Structure

```id="zslp0t"
ApiClient
  - request(method, endpoint, params)
  - getLists()
  - getSubscribers(listId, limit=20)
```

---

## Endpoints (Assumed)

Since the exact API details are not fully specified, the implementation should:

* Use official documentation where available
* Be flexible to adjust endpoints

### Expected operations:

#### 1. Get Lists

* Returns all contact lists

#### 2. Get Subscribers

* Requires list ID
* Supports limiting results (first 20)

---

## Data Normalization

API responses should be transformed into a consistent internal format.

Example:

```id="l8dfxu"
List:
- id
- name
- size
- created_at

Subscriber:
- id
- email
- name (if available)
- created_at
```

---

## Error Handling Strategy

The API client must detect and handle:

* HTTP errors (4xx, 5xx)
* Invalid credentials
* Empty responses
* Malformed data

Errors should be:

* Logged (optional)
* Passed to the UI in a user-friendly format

---

## Extensibility

The API layer should be isolated so that:

* Endpoint changes are localized
* Mocking is possible (for testing if needed)

## Known Constraints About the API

If exact API documentation is not available during implementation:

* The developer (Claude) must:

    * Look up official SalesAutopilot API documentation
    * Verify endpoints before implementing
    * Avoid guessing endpoint structures

## Implementation Strategy for Unknown API

1. First step:

    * Identify correct endpoints for:

        * listing contact lists
        * retrieving subscribers

2. Validate:

    * Authentication method
    * Required headers
    * Response format

3. Only after validation:

    * Implement API client methods

## Important Rule

Do NOT hardcode or assume API responses without verification.

