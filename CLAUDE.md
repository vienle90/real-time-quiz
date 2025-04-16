# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands
- Run server: `php artisan serve`
- Start all services: `composer dev`
- Run tests: `php artisan test`
- Run single test: `php artisan test --filter TestClassName::testMethodName`
- PHP linting: `./vendor/bin/pint`

## Code Style Guidelines
- Always use `declare(strict_types=1);` in PHP files
- Use typehints for method parameters and return types
- Follow Laravel conventions for repository pattern with interfaces in Contracts namespace
- Dependency injection via constructor for Services and Repositories
- Use readonly properties for injected dependencies
- Document types with PHPDoc (`@var`, `@return`, `@param`) for collection types
- Services should be thin orchestration layers between controllers and repositories
- Repositories should handle all database interaction
- Follow PSR-12 coding standards
- Snake case for database columns, camel case for properties
- Events follow naming convention of past tense verbs (e.g., `QuestionAnswerSubmitted`)
- Use explicit visibility modifiers (public, private, protected)