# Error Handling

## Strategy

Errors are handled at two levels:

* API level
* Application level

All errors must result in user-visible feedback.

---

## Error Cases

### 1. Invalid API Credentials

* Detection: API returns authentication error
* Handling:

    * Show error message
    * Suggest checking credentials

---

### 2. API Request Failure

* Causes:

    * Network issues
    * Timeout
* Handling:

    * Display generic error message
    * Optionally retry

---

### 3. Empty Data

#### No Lists

* Show: "No lists found"

#### No Subscribers

* Show: "No subscribers in this list"

---

### 4. Invalid Input

#### Invalid List ID

* Show: "Invalid list selected"

#### Invalid Filter/Sort

* Ignore OR show warning

---

### 5. Unexpected API Response

* Handling:

    * Show fallback error
    * Do not crash application

---

## UX Approach

* Errors displayed inline (top of page)
* No technical jargon
* Clear and concise messaging

---

## Logging (Optional)

* Errors can be logged to file for debugging
* Not required for this assignment
