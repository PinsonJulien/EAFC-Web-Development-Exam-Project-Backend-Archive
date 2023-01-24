# School Website - Backend Laravel

## WORK IN PROGRESS

This repository is part of the web development project of my bachelor degree in Business Computing.

## How to setup the project
### Database requirements
- Make sure your mysql database:
    - Is using `InnoDB` as the engine.
    - Has `default-row-format` set to `dynamic`.

### First launch
- run `composer install`
- Copy the `.env.config` file to `.env`.
- Fill the environment variables.
- Make the sure the .env has `FILESYSTEM_DRIVER=public` this will ensure the files are properly saved.
- Run `php artisan key:generate` (this will fill the `APP_KEY` environment variable).
- Run `php artisan migrate` command.
- For demo purpose you can run `php artisan db:seed --class=DemoSeeder` to populate the database.
- If you store files locally, run : `php artisan storage:link` to create a symbolic link between "public/storage" and "storage/app/public"

## How to serve the project
Run `php artisan serve`

## Ideas
- Calendar to deal with courses and formations being available multiple times (instead of updating each entry)
- Tokens must have 24h limit of validity

## Possible improvements
- Dynamic api routing
  - get folders
  - path is name of the folder with a first lowercase
  - include routes from inside the folder
- Improve seeders

## Todo
- Todo's in the source code.
- User:
  - cannot delete user if they're a student. maybe use the guest siteRole to determine it ?
    - Accepted request automatically set the user role to USER 
  - When a user is deleted : delete their picture from storage and update model to null it.

- CohortMembers
  - All CRUD

- App access
  - Policies secures all controller methods using the site_role.

- Courses
  - when assigning a group to a course, only create grades for students.
 
- groups
  - Name, timestamps (to determine school year 20XX - 20YY) 
  - user_group (user_id, group_id)
  - controller allows to add new user to a group, remove, (un)subscribe the whole group to a formation or course.
  - On delete, remove all entries in user_group, maybe unsubscribe the linked users from any formation / course.
- don't allow adding the same person to the same cohort twice (via the respective custom Request)

## Contribution tools
### Useful commands to work with
- generate a new model and related classes : `php artisan make:model Name -mfsc`
- refresh migrations : `php artisan migrate:refresh`
- reset migrations : `php artisan migrate:reset`
- generate resource : `php artisan make:resource V1\Name\NameResource`
- generate collection : `php artisan make:resource V1\Name\NameCollection`
- generate request : `php artisan make:request V1\Name\StoreNameRequest`
