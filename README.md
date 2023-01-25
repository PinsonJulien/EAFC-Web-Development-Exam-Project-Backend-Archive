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

## Possible improvements
- Dynamic api routing
  - get folders
  - path is name of the folder with a first lowercase
  - include routes from inside the folder
- Improve seeders
- Reduce code repetition in controllers.

## Todo
- Todo's in the source code.
- User: 
  - Cannot update their own role.

- Cohort
  - GET /cohorts/{cohort}/users : Return all users of the cohort.
  - POST /cohorts/{cohort}/users : Add user with role.
  - PUT/PATCH /cohorts/{cohort}/users/{user} : Update the role of a user.
  - DELETE /cohorts/{cohort}/users/{user} : Removes a user from a cohort.
  - POST /cohorts/{cohort}/courses/{course}
    - Store a new Grade for all students in the cohort, if they're not subscribed.

- Enrollment
  - Upon approved :
    - if guest: Change user siteRole to [user].
    - Create automatically a cohort to the formation for the current year. New one every 1st september.
    - Add the user to this cohort with the cohort_role [student]
  - update / delete that are not [pending] should be returning [HTTP Locked].

- App access
  - Policy secures all controller methods using the site_role.
  - Tokens must have 24h limit of validity
  - See all auth requests / controllers.
  - signUp :
      - Auth::login($user); at the end.



## Contribution tools
### Useful commands to work with
- generate a new model and related classes : `php artisan make:model Name -mfsc`
- refresh migrations : `php artisan migrate:refresh`
- reset migrations : `php artisan migrate:reset`
- generate resource : `php artisan make:resource V1\Name\NameResource`
- generate collection : `php artisan make:resource V1\Name\NameCollection`
- generate request : `php artisan make:request V1\Name\StoreNameRequest`
