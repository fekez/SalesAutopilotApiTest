# Open Questions

## 1. SalesAutopilot API Details

* Exact endpoints are not fully specified
* Response formats may vary
* Authentication method assumptions may need adjustment

---

## 2. Filtering Definition

* What exactly counts as "filtering"?
* Is simple string matching sufficient?
* Should multiple filters be supported?

(Current decision: simple, single-field filtering)

---

## 3. Sorting Scope

* Which fields should be sortable?
* Should sorting be ascending only or both directions?

(Current decision: basic fields, simple implementation)

---

## 4. API Pagination

* Does the API support pagination?
* Are we guaranteed to receive only 20 items?

(Current decision: manually limit to first 20)

---

## 5. Error Response Format

* How does the API return errors?
* Are error codes consistent?

---

## 6. Authentication Flow

* Should UI-based credential input be required?
* Or is `.env` sufficient?

(Current decision: `.env` primary)
