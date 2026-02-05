# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

Taekwondo tournament medal calculation system (Perhitungan Medali). Manages events, dojangs (martial arts schools), participants, tournament categories, registrations, and medal tracking with point calculations.

## Commands

### Development
```bash
composer dev          # Runs Laravel server, queue worker, and Vite concurrently
php artisan serve     # Laravel server only
npm run dev           # Vite dev server only
```

### Setup
```bash
composer setup        # Full setup: install deps, copy .env, generate key, migrate, build assets
```

### Testing
```bash
composer test                           # Run all tests (clears config first)
php artisan test                        # Run tests directly
php artisan test --filter=MethodName    # Run specific test
php artisan test tests/Feature/CrudRoutesTest.php  # Run specific file
```

Tests use **Pest** (not PHPUnit directly). Feature tests use `RefreshDatabase` trait automatically via `tests/Pest.php`.

### Code Formatting
```bash
./vendor/bin/pint     # Format code with Laravel Pint
./vendor/bin/pint --test  # Check formatting without changes
```

### Database
```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh        # Drop all tables and re-run migrations
php artisan migrate:fresh --seed # Fresh migrate with seeders
```

## Architecture

### Domain Model Relationships
```
Event
├── Contingent (team representing a Dojang at an Event)
│   └── Registration (participant entry in a category)
└── TournamentCategory (competition category)
    └── Registration

Dojang (martial arts school)
├── Participant (athlete)
└── Contingent

Registration → Medal (nullable, assigned when placed)
```

### Key Enums (`app/Enums/`)
- **TournamentType**: `kyourugi` (sparring), `poomsae` (forms)
- **CategoryType**: `festival` (recreational), `prestasi` (competitive)
- **PoomsaeType**: `individual`, `pair`, `team`
- **TournamentGender**: competition gender categories
- **ParticipantGender**: athlete gender

### Controllers Pattern
Controllers support both web (Blade views) and JSON API responses. Check `request()->expectsJson()` to determine response format. Standard Laravel resource controllers with validation rules defined in private `rules()` method.

### Views Structure
Blade templates in `resources/views/`. Each resource has its own directory with index, create, edit views. Layout in `layouts/`, reusable components in `components/`.

### Point System
Events define `gold_point`, `silver_point`, `bronze_point` values. Medal rankings are calculated per contingent based on these point values.

## Conventions

- Model files use lowercase filenames (e.g., `participant.php`) except `TournamentCategory.php`
- Indonesian labels in UI (Emas/Perak/Perunggu for Gold/Silver/Bronze)
- PHP 8.2+ backed enums with `label()` and `color()` helper methods
- Factories exist for all models in `database/factories/`
