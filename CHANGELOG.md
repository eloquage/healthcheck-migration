# Changelog

All notable changes to `healthcheck-migration` will be documented in this file.

## v0.1.6 - 2026-11-03

Release the package with Composer identity under the eloquage vendor namespace. This release contains the package metadata and documentation rename; runtime behavior is unchanged.

## 0.1.5 - 2026-10-23

- Limit supported Laravel versions to 12 and 13.
- Warn by default when migrations are pending, with an option to fail the check.
- Fail the check when Laravel cannot read migration status.
- Document installation, configuration, usage, and testing.
