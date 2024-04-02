# boat-mvc-laravel


## Description
The Boat Application is a web-based platform developed as part of a coding challenge. It allows users to manage boats by performing CRUD (Create, Read, Update, Delete) operations. Users can create new boats, update existing ones, and delete them from the system. Additionally, they can view a list of all boats and access details of specific boats.

## Technologies Used
- Laravel: PHP framework for building web applications.
- MySQL: Relational database management system for data storage.
- Docker: Containerization platform for easy deployment.
- Bootstrap: Front-end framework for responsive design.

## Setup Instructions
1. Clone the repository to your local machine.
2. Navigate to the project directory.
3. Copy `.env.example` to `.env`
4. Run `docker-compose up -d --build` to start the Docker containers.
5. Access the PHP container's shell with `docker-compose exec php bash`.
6. Run `composer install`
7. Run `php artisan migrate`
8. Run `php artisan db:seed`
5. Access the application in your browser at `http://localhost:80`.

## Testing
- Run `php artisan test` from the PHP container's shell to execute the tests.

## Code Formatting
- Use EasyCodingStandard (ECS) to check and fix code formatting.
- Run `vendor/bin/ecs check` from the PHP container's shell to check and fix formatting issues.
- To run static code analysis (PHPStan): `./vendor/bin/phpstan analyse`
- To run RectorPHP: `vendor/bin/rector`
