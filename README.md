# School Website - Backend Laravel

## WORK IN PROGRESS

This repository is part of the web development project of my bachelor degree in Business Computing.

## Minimal requirements
- PHP 8.0
- MySQL 5.7.36
- Composer 2.3.10

### Database configuration
- Make sure your mysql database:
    - Is using `InnoDB` as the engine.
    - Has `default-row-format` set to `dynamic`.

## Initial setup
- run `composer install`
- Copy the `.env.config` file to `.env` and replace environment variables that do not fit your database configuration.
- Make the sure the .env has `FILESYSTEM_DRIVER=public` this will ensure the files are properly saved.
- Run `php artisan key:generate` (this will fill the `APP_KEY` .env variable).
- Run `php artisan storage:link` to create a symbolic link between "public/storage" and "storage/app/public"
- Run `php artisan migrate` command to generate all the tables.

## Prepare for the demo
- Run `php artisan db:seed --class=DemoSeeder` to populate the database.
- Each SiteRole has an initial User, you can log yourself using these credentials (email ; password)
  - Guest: guest@site.com ; guest
  - User: user@site.com ; user
  - Secretary: secretary@site.com ; secretary
  - Administrator: administrator@site.com ; administrator
  - Banned: banned@site.com ; banned

## How to serve the application
Run `php artisan serve`

## Contribution tools

### Postman collection
Developers can import the `postman_collection.json` at the root of the project if they want to test this application without a frontend.

### Seeding for all the environments
- Demo : `php artisan db:seed --class=DemoSeeder`
- Development : `php artisan db:seed --class=DevelopmentSeeder`
- Production : `php artisan db:seed --class=ProductionSeeder`

### Useful commands to work with
- generate a new model and related classes : `php artisan make:model Name -mfsc`
- refresh migrations : `php artisan migrate:refresh`
- reset migrations : `php artisan migrate:reset`
- generate resource : `php artisan make:resource V1\Name\NameResource`
- generate collection : `php artisan make:resource V1\Name\NameCollection`
- generate request : `php artisan make:request V1\Name\StoreNameRequest`
- generate policy : `php artisan make:policy NamePolicy --model=Name`

## Project current state

### Ideas
- Calendar to deal with courses and formations being available multiple times (instead of updating the formation start / end dates)

### Possible improvements
Most of these consists of details I have in mind to improve the project and however lack the time to polish :

- Dynamic api routing
  - get folders
  - path is name of the folder with a first lowercase
  - include routes from inside the folder
- Improve seeders
- Reduce code redundancy in controllers.
- Improve controllers by using observers on models.
- models should also return errors whenever a resource is locked for example, and handled by the controller.
- Make the application /api route only. The Laravel Passport will however not be able to work with sessions. 
  For this project however, I had to work with sessions, not tokens (?)
- Roles-based authorization should have been dynamic, possibly, allow a granular field by field limitation.

### Todo
- User:
  - {user}/export using the controller method, but with only the said user.
    - generic singleExport() method ?

- App access
  - Policy secures all controller methods using the site_role.
  - Tokens must have 24h limit of validity*
  - Middleware to deal with banned users.
  
- Available for non logged :
  - formations & course; in the resources, block some relations by role not to everything.
