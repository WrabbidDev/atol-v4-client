# Changelog

All notable changes to this project will be documented in this file.

## 1.0.0 - 2026-10-01

- Added `ResponseFactory` for register, correction, report, and callback payloads.
- Client document and report calls now build responses through the factory.
- Mapped snake_case response fields (`group_code`, `daemon_code`, `device_code`, `external_id`, `callback_url`, `timestamp`).
- Documented callback payload handling and the optional service callback URL.

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
