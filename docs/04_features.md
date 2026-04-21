# Features

## Feature 1: Authentication

### Input

* API credentials from `.env` or user input

### Process

* Load credentials
* Validate presence
* Pass to API client

### Output

* Authenticated API requests

### Edge Cases

* Missing credentials
* Invalid credentials

---

## Feature 2: List Retrieval

### Input

* Authenticated API client

### Process

* Fetch all lists
* Transform response

### Output

* Display list of:

    * Name
    * Size
    * Creation date

### Edge Cases

* No lists
* API failure

---

## Feature 3: List Selection

### Input

* Selected list ID (via GET parameter)

### Process

* Validate list ID
* Fetch subscribers for selected list

### Output

* Display subscriber list

### Edge Cases

* Invalid list ID
* Empty subscriber list

---

## Feature 4: Subscriber Listing

### Input

* List ID

### Process

* Fetch first 20 subscribers

### Output

* Display:

    * Email
    * Name (if available)
    * Created date

---

## Feature 5: Filtering / Sorting

### Interpretation

The requirement is open-ended. The chosen approach:

* Use simple query parameters:

    * `?sort=email`
    * `?sort=created_at`
    * `?filter=email_contains=example`

### Implementation

* Sorting:

    * Alphabetical (email)
    * Date-based (created_at)

* Filtering:

    * Basic string match (e.g. email contains)

### Processing

* Apply filtering/sorting:

    * After fetching data (in-memory)
    * Not via API (simplifies implementation)

### Output

* Updated subscriber list

### Edge Cases

* No matching results
* Invalid filter/sort parameters
