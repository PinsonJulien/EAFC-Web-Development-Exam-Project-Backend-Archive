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
- For demo purpose you can run `php artisan db:seed --class=DemoSeeder` to populate the database.

## How to serve the project
Run `php artisan serve`

## Known issues
None... yet !

## Objectives
- Setting up :
  - models
  - seeders
  - factories
  - controllers
  - routes
- Tokens must have 24h limit of validity
- Routes should be secured.

- Get all requests should return the count of rows and use request headers to provide a offset and number to deal with pagination.
