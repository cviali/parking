# parking
simple parking backend system with Laravel to make cool frontend or apps

backend features:
- roles (admin and employee)
- input vehicle code to get unique code
- input the generated unique code to get the vehicle code, when it was inputted, and how much is the fare (IDR 3k per hour)
- see inputted vehicle code and their info and statuses.

example for the backend usage is available in the resources folder, there's a Laravel Blade frontend system that uses all of the backend features.

# todo
- learn to make api endpoint
- some documentations
- translate this thing to english

# how to use
- setup a Laravel local environment, use any local server environment setup program such as XAMPP or Laragon.
- composer install
- php artisan migrate to setup a local database
