<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Project: 

Laravel 8 with CRUD: users, favorite movies, products and tags

### To Run

* Requirements: Docker

#### Using Sail
````
git clone https://github.com/estudos-2022/crud-laravel8-app.git appLaravel8
cd appLaravel8
composer install
./vendor/bin/sail up
cp .env.example .env
./vendor/bin/sail php artisan key:generate
touch database/database.sqlite
./vendor/bin/sail php artisan migrate
./vendor/bin/sail php artisan db:seed
````

#### Using Local Server 
````
# Clone
git clone https://github.com/estudos-2022/crud-laravel8-app.git appLaravel8

# Enter in folder
cd appLaravel8

# Install depedencies
composer install

# Copy the variable of enviroment, and revise the config
cp .env.example .env

# Create the key
php artisan key:generate

# Create the database of Sqlite, except if to use other DB 
touch database/database.sqlite

# Run migration to create the tables of database - to run seed together [php artisan migrate::refresh --seed]
php artisan migrate

# Run Seed to create some data (roles...) 
php artisan db:seed
````


* About Sail: https://laravel.com/docs/8.x/sail

After, visit the following address: http://localhost

To run Unit Test: `./vendor/bin/sail test` or `php artisan test`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
