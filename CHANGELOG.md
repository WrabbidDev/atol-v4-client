# Changelog

All notable changes to this project will be documented in this file.

## 0.9.0 - 2026-09-25

- Initial public package setup for ATOL Online v4 client.
- Implemented API client logic with:
  - token retrieval/caching/invalidation;
  - token-expiration retry flow;
  - document registration and status report calls.
- Added token transport modes:
  - header (`Token`) by default;
  - optional query string (`?token=...`).
- Added PHPUnit coverage for:
  - token retry behavior;
  - request validation behavior.
- Flattened DTO layout and updated namespaces.
- Added package metadata, scripts, and CI workflow.
