# Simple Blog

[![N|Solid](https://cldup.com/dTxpPi9lDf.thumb.png)](https://nodesource.com/products/nsolid)

Simple Blog is a hand tailored blog system designed on some of the hottest opensource technologies such as Laravel a PHP framework, that could be developed easily in simple level.

  - [Requirements][RL1]
  - [Installation][IL1]
  - [Troubleshooting][TL1]
  - [License][LL1]

# Requirements:

- PHP >= 7.2.0
- MCrypt PHP Extension
- MySQL Server version 5.7.23 or higher
    -  or MariaDB version 10.2.7 or higher.
- Composer: 1.6.5 or higher.
- SERVER: Apache 2 or NGINX in case of creating virtual host instead of php lightweight simple server on one port rather than the default port.


# Installation & Configuration :

- Step 1: Get the code - Download the repository
- Step 2: Use Composer to install dependencies
Navigate to the root directory of the project you cloned or downloaded then execute these commands below as in their order:
    ```sh
    $ composer install
    ```
- Step 3: Create & Configure your database
If you finished first two steps, now you can create database on your database server(MySQL). You need to create database preferably with utf-8 collation(uft8_general_ci), to install and for the application to work perfectly.
- Step 4: Set the Environment Variables
Find file named ".env.example" inside the root directory. Copy the file then rename the new one ".env" and set the environment variables listed below:
    - MYSQL_DB_CONNECTION
    - MYSQL_DB_HOST
    - MYSQL_DB_PORT
    - MYSQL_DB_DATABASE
    - MYSQL_DB_USERNAME
    - MYSQL_DB_PASSWORD
as per your database configurations.


- Step 5: Generate App Key
    Run the following command using the CLI where the project exists:
  ```sh
    $ php artisan key:generate
    ```
assert to get the prompt output saying "Application key set successfully."

- Step 6: Install
    Now that you have the environment configured, you need to create a database schema for your app. To create database tables and to initial populate them use this command:
    ```sh
    $ php artisan migrate --seed
    ```
    it will create the database with initial dummy and fake data as placeholders .

- Step 7: Start Page
    - On server:
        ```
        Open the specified entry point in your hosts file in browser or make entry in hosts file if not done.
        ```
    - On local:
        ```sh
            $ php artisan serve
        ```
    How to log in as admin:
    ```
        email:admin@admin.com
        password: admin@123
    ```
    How to log in as user:
    ```
        email:user@user.com
        password: user@123
    ```
### Troubleshooting
Site loading very slow?
```sh
    $ composer dump-autoload --optimize
```
Or
```sh
    $ php artisan dump-autoload
```

### License

This is free software distributed under the terms of the WTFPL license along with MIT license as dual-licensed, You can choose whatever works for you.
Please review the [LICENSE.md] [LMDL1] file included for this purpose.

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)


   [RL1]: <https://github.com/ahmadSaeedGoda/simple-blog#Requirements>
   [IL1]: <https://github.com/ahmadSaeedGoda/simple-blog#Installation>
   [TL1]: <https://github.com/ahmadSaeedGoda/simple-blog#Troubleshooting>
   [LL1]: <https://github.com/ahmadSaeedGoda/simple-blog#License>
   [LMDL1]: <https://github.com/ahmadSaeedGoda/simple-blog/blob/master/LICENSE.md>