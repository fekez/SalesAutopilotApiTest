# Requirements

## Functional Requirements

### 1. Authentication

* The application must accept SalesAutopilot API credentials:

    * Username
    * Password
* Credentials can be provided:

    * Via `.env` file
    * Or via user input (optional UI)

### 2. List Retrieval

* Fetch and display all lists from the SalesAutopilot account
* Each list must include:

    * Name
    * Size (number of subscribers)
    * Creation date

### 3. List Details

* User must be able to select a list
* Display the first 20 subscribers of the selected list

### 4. Subscriber Filtering / Sorting

* The application must provide a way to:

    * Filter OR
    * Sort subscribers
* The exact implementation is open-ended and must be justified

---

## Technical Requirements

* Use PHP (version must be justified in REFLECTION.md)
* Use Docker with `docker-compose.yml`
* The app must run with:

  ```bash
  docker compose up
  ```
* No external database required
* If used, it must run in Docker
* Environment variables must be handled via `.env`
* `.env.example` must be included in the repository

---

## Error Handling Requirements

The application must handle and communicate the following cases:

* Invalid API credentials
* API request failure (network issues, timeouts)
* Empty lists or no subscribers
* Unexpected API responses
* Any additional edge cases identified during implementation

The way errors are communicated to the user is up to the implementation.

---

## Deliverables

### Required Files

* `AI_LOG.md`

    * Key AI interactions
    * Decision points
    * Debugging steps
    * No censorship

* `REFLECTION.md`

    * 8–12 sentences covering:

        * Interpretation of filtering/sorting requirement
        * AI model usage and reasoning
        * Where AI helped vs. required correction
        * What would be done differently next time

### Repository

* Must be public
* Must contain all necessary files to run the project
