# Repository Guidelines

## Project Structure & Module Organization
- `logs/` stores the daily #100DaysOfCode journal; keep filenames in the `dayNN.md` pattern so entries stay chronological.
- `laravel-projects/task-manager/` is the active Laravel 12 app. Domain logic sits in `app/`, UI assets in `resources/`, database artifacts in `database/`, and automated checks in `tests/`.
- `nextjs-projects/`, `misc-projects/`, and `resources/` are placeholders—spin up a subfolder per project and add a README when work begins.

## Build, Test, and Development Commands
- First-time setup: `cd laravel-projects/task-manager && composer install && bun install` to sync PHP and frontend dependencies.
- Local dev stack: `composer run dev` launches the PHP server, queue listener, log tail (Pail), and Vite watcher together.
- Database refresh: `php artisan migrate:fresh --seed` resets the bundled SQLite database in `database/database.sqlite`.

## Coding Style & Naming Conventions
- PHP code follows PSR-12 with 4-space indentation; run `php vendor/bin/pint` before committing.
- Frontend assets rely on Prettier; keep `bun run format` and `bun run format:check` green.
- Livewire components live under `App\\Livewire\\` in StudlyCase (`ChallengeDashboard`); Blade views stay lowercase-kebab (`resources/views/challenges/show.blade.php`).
- Daily logs begin with `# Day X/100` and concise bullet summaries to match existing entries.

## Testing Guidelines
- Feature and unit tests live in `tests/Feature` and `tests/Unit`; keep filenames suffixed with `Test.php` and method names descriptive (`test_user_can_start_challenge`).
- Run the suite with `composer test` (clears cached config) or `php artisan test` for quick feedback, leaning on Pest conventions.
- Cover new Livewire components and validation rules to protect the challenge tracker workflow.

## Commit & Pull Request Guidelines
- Follow the existing Git history: prefix summaries with a conventional type (`feat:`, `fix:`, `chore:`) and add body bullets when touching several areas.
- Reference related log updates or issues in the PR description and include screenshots or clips for UI tweaks.
- Ensure formatters and tests pass locally before opening a PR to keep review cycles tight.

## Documentation & Knowledge Sharing
- Update `logs/dayNN.md` alongside functional work so the challenge narrative stays synchronized.
- Before ending the day, append an English entry to `logs/dayNN.md` that captures the day's challenge progress and reflection.
- Park supplementary notes, cheat sheets, or architectural decisions in `resources/` with clear filenames (`livewire-flux-cheatsheet.md`).
