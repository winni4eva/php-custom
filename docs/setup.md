## PROJECT SETUP

```
Requirements
- PHP: ^8.0.2
- MySQL
- Composer

```

+ Clone project repository
+ Change directory into project root
+ Run `composer install` command to install project dependencies
+ Create a .env file in your project root, you can use the .env.example as a template
 * Update the environment keys to match your database credentials
 * ```
 APP_ENV=development
 DB_HOST=localhost
 DB_PORT=3306
 DB_DATABASE=
 DB_USERNAME=
 DB_PASSWORD=
 ```
+ Run database migrations by using the command `vendor/bin/phinx seed:run` from the project root
+ Run database seeds by using the command `vendor/bin/phinx migrate -e development` from the project root
+ start the server by using the command `php -S localhost:8000 -t src`
+ Follow the api docs section to add accounts and transfer funds between accounts