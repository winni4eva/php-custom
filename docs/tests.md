## TESTS

```
Requirements
- PHP: ^8.0.2
- MySQL
- Composer

```

+ Create a test database
+ Update phpunits configuration in phpunit.xml to match your test db credentials
    * ```
    <php>
        <env name="APP_ENV" value="testing" />
        <env name="DB_HOST" value="localhost" />
        <env name="DB_PORT" value="3306" />
        <env name="DB_DATABASE" value="test_db" />
        <env name="DB_USERNAME" value="root" />
        <env name="DB_PASSWORD" value="" />
    </php>
    ```
+ to run tests use the command `composer test` or `./vendor/bin/phpunit`