# School Website - Backend Laravel

## WORK IN PROGRESS

This repository is part of the web development project of my bachelor degree in Business Computing.

## How to setup the project
### Database requirements
- Make sure your mysql database:
    - Is using `InnoDB` as the engine.
    - Has `default-row-format` set to `dynamic`

### First launch
- run `composer install`
- Copy the `.env.config` file to `.env`.
- Fill the environment variables.
- Run `php artisan key:generate` (this will fill the `APP_KEY` environment variable).
- run `php artisan migrate` command.

## How to serve the project
`php artisan serve`

## Known issues
None... yet !

## Objectives
- Setting up the entities
- Set laravel to be an API backend
- Tokens must have 24h limit of validity;