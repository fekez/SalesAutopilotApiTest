# Project Overview

## Purpose

This project is a simple PHP-based web application that integrates with the SalesAutopilot REST API. The goal is to demonstrate the ability to work with an external API, structure a small application, and handle incomplete specifications using engineering judgment.

## Scope

The application allows users to:

* Authenticate using SalesAutopilot API credentials
* View available contact lists
* Inspect subscribers of a selected list
* Apply basic filtering or sorting on subscribers

## Tech Stack

* PHP (native, no framework)
* Composer (for dependency management)
* Docker (for environment setup and execution)

## Constraints

* No external database is required
* Application must run with a single command: `docker compose up`
* API credentials must be loaded from a `.env` file or user input
* The `.env` file must not be committed, but `.env.example` must be included

## Non-Goals

* No complex frontend (simple server-rendered UI is sufficient)
* No authentication system beyond API credential usage
* No persistent storage required

## Expected Outcome

A working minimal web application that:

* Communicates with the SalesAutopilot API
* Displays lists and subscribers
* Handles errors gracefully
* Demonstrates clear architectural decisions and development reasoning
