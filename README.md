## Banking API

### Environment setup

Banking API is build with the following setup

* Programming Language [PHP v8.1](https://www.php.net/) with the framework [Laravel v10.x](https://laravel.com/)
* SQL Database is [MySQL 5.7](https://www.mysql.com/)
* Dependencies installer [Composer](https://getcomposer.org/)

### Deployment

To run the API,

* Start the MySQL server and create database with name banking_api
* MySQL Information
>   DB_DATABASE=banking_api
>
>   DB_USERNAME=root
> 
>   DB_PASSWORD=

* Here are the following commands to run the Banking-API

Open the terminal, 

>   git clone [https://lebigdonald@bitbucket.org/lebigdonald/banking-api.git](https://bitbucket.org/lebigdonald/banking-api/src/main/)

>   cd banking-api 

Install all the dependencies
>   composer install --no-interaction --no-ansi

Generate the .env file from .env.example
>   cp .env.example .env

Generate the APP_KEY
>   php artisan key:generate

Create the database table and procedures
>   php artisan migrate

>   ####    NB: The API is protected by an API Key, You have to copy the value of APP_KEY in the .env file.

Run a sample unit test
>   php artisan test

After running all the previous commands and added the API_KEY value, you run the command to start the server
>   php artisan serve

To view all the end points and their documentations,
>   Locally - [http://localhost:8000/request-docs](http://localhost:8000/request-docs)
> 
>   Postman - https://pether-corporation.postman.co/workspace/Banking-API~1c27601a-49ca-4d26-9a1d-a3d6d41f23f2/api/3a6efbcf-aefb-4df9-a45d-39ac2e3eeab6?action=share&creator=10247388
