# AI_LOG.md

## Session Context

The goal was to design and prepare a PHP application integrating with the SalesAutopilot API, with a strong focus on structured thinking, decision-making, and efficient AI usage.

---

## 1. Initial Structuring

### Prompt Summary

User provided the full task description and asked for a structured breakdown into `.md` files for efficient token usage and AI processing.

### AI Response

Proposed a modular documentation structure:

* Project overview
* Requirements
* Architecture
* API integration
* Features
* Error handling
* Decisions
* Tasks
* Milestones
* Open questions

### Key Outcome

A **10-file documentation structure** optimized for:

* Token efficiency
* Iterative AI processing
* Clear separation of concerns

---

## 2. Technology Decision

### Question

Framework vs native PHP?

### Decision

Native PHP + Composer packages

### Reasoning

* Simplicity
* Transparency
* Avoid overengineering
* Still allows use of tools like dotenv and HTTP clients

---

## 3. Documentation Creation

### Action

AI generated the following files:

* `00_project_overview.md`
* `01_requirements.md`
* `02_architecture.md`
* `03_api_integration.md`
* `04_features.md`
* `05_error_handling.md`
* `06_decisions.md`
* `07_tasks.md`
* `08_milestones.md`
* `09_open_questions.md`

### Key Insight

Documentation is:

* Structured for AI consumption
* Not just descriptive, but actionable

---

## 4. Filtering / Sorting Interpretation

### Requirement

Open-ended requirement:

> filtering or sorting subscribers

### Decision

* Use GET query parameters
* Perform in-memory filtering/sorting

### Example

* `?sort=email`
* `?filter=email_contains=test`

### Reasoning

* Simple
* Transparent
* No dependency on API capabilities
* Easy to explain in reflection

---

## 5. API Integration Risk Identified

### Issue

SalesAutopilot API not fully specified

### AI Correction

Added explicit constraints:

* Do NOT assume endpoints
* Must verify API documentation before implementation

### Outcome

Reduced hallucination risk during implementation

---

## 6. Routing Clarification

### Issue

Routing not explicit enough

### Solution

Defined:

* `?page=lists`
* `?page=subscribers&list_id=...`

### Outcome

* Prevents overengineering
* Ensures predictable structure

---

## 7. Execution Strategy for Claude

### Goal

Enable Claude to implement the project efficiently

### Solution

Created a **kickoff prompt** with:

* Step-by-step context loading
* Iterative file reading
* Strict implementation order
* Anti-hallucination rules

### Key Rule

Do NOT load all documentation at once

---

## 8. SPEC.md Usage

### Addition

User created `SPEC.md` with original task

### Decision

* Treat as source of truth
* Use only when clarification is needed

---

## 9. Final State

At the end of the session:

* Full documentation structure created
* All major technical decisions defined
* Risks identified and mitigated
* Execution strategy for AI prepared

---

## Summary of AI Usage

### Where AI helped most

* Structuring the problem
* Defining architecture
* Identifying risks
* Creating implementation strategy

### Where human decisions were critical

* Choosing native PHP
* Defining filtering behavior
* Controlling complexity
* Ensuring alignment with task expectations

---

## Notes

* The process emphasized clarity over completeness
* The goal was not perfect code, but strong reasoning and structure
* The setup is optimized for iterative AI-assisted development


---

## 10. Implementation Phase — Claude Sonnet 4.5 (claude.ai)

### Context

After the planning and documentation phase (handled by ChatGPT), the actual implementation was handed off to Claude Sonnet 4.5 via claude.ai, using the structured documentation as a kickoff prompt.

### Approach

Claude was instructed to:
* Read only 2 docs at a time, iteratively
* Summarize understanding before proceeding
* Ask clarifying questions before coding
* Follow a strict implementation order: Docker → skeleton → routing → API client → features → error handling

### Key Interactions

#### Docker Setup
Claude generated the `Dockerfile`, `docker-compose.yml`, `.env.example` and `composer.json` in one step.
A bug was introduced: an empty `docker-php-ext-install` call caused a build failure.

**Fix:** Docker Gordon (AI-powered Docker assistant) was used to identify the root cause. The empty ext-install line was removed — the base `php:8.2-apache` image already included all required extensions.

#### API Research
Claude proactively searched for the real SalesAutopilot API documentation before writing any API code. The V1 base URL (`restapi.emesz.com`) was initially assumed, but corrected after the user shared the official Hungarian support docs:
* `https://api.salesautopilot.com` is the correct base URL for both V1 and V2
* `GET /getlists` was identified as the list retrieval endpoint
* `GET /listtotalcount/<id>` for list size (separate sequential calls required due to rate limit)
* `POST /list/<id>/order/subdate/asc/20` for paginated subscriber retrieval

#### .env Handling Bug
Initial implementation used `createImmutable()->load()` which required a full `docker compose down -v && docker compose up --build` on every `.env` change.

**Fix:** Switched to `createUnsafeMutable()->safeLoad()` — after this change, a simple `docker compose restart` is sufficient.

#### Error Handling
All SPEC-required error cases were implemented and manually verified:
* Missing `.env` → user-friendly config error page
* Invalid API credentials → 401 with clear message
* Empty list → graceful empty state message
* API timeout → 503 with degradation message
* Rate limit (429) → handled in `handleRequestException()`

#### Filtering & Sorting Decision
Claude proposed and implemented client-side (in-memory) filtering and sorting on the fetched 20 subscribers. This avoids additional API calls and rate limit issues, while fully satisfying the open-ended SPEC requirement.

#### Smoke Tests
A CLI smoke test script (`tests/smoke_test.php`) was created covering all SPEC-required error cases, runnable via:
```bash
docker compose exec app php tests/smoke_test.php
```

### Where Claude Helped Most
* Iterative, cautious API research — no endpoint guessing
* Clean error handling architecture (`ApiException`, match expression)
* Identifying the `.env` reload issue and proposing the fix
* Generating the smoke test script covering all cases in one pass

### Where Human Correction Was Needed
* Docker Gordon identified the Dockerfile bug Claude introduced
* User identified that the new platform uses `app2.salesautopilot.com` (V2), not the legacy URL
* User provided the official Hungarian API docs that Claude could not access (403)
* `.env` safeLoad fix was triggered by user observation, not proactive Claude detection