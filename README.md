TestHub - service for testing skills

Installation
-
- Download source code from git
- Copy `.env.dist` to `.env` and configure `DATABASE_URL` in `.env` file
- Create database: `php bin/console doctrine:database:create`
- Run migrations: `php bin/console doctrine:migrations:migrate`
- Fill database with dummy data, if needed: `php bin/console doctrine:fixtures:load`

Tests
-
Load tests: `php bin/phpunit`