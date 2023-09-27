# Mason

A Content Management System (CMS) built with PHP Laravel

## How to Install

1. Clone the repository

`git clone https://github.com/optimumweb/mason.git`

2. Create a `.env` file from `.env.example`

`cp .env.example .env`

3. Enter your database information in the `.env` file

Look for the following variables:

`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

4. Install composer dependencies

`composer install`

5. Complete full setup

`php artisan mason:setup`

6. Deploy app

`php artisan mason:deploy`

## Security Vulnerabilities

If you discover a security vulnerability within Mason, please send an e-mail to Jonathan Roy via [jroy@optimumweb.ca](mailto:jroy@optimumweb.ca). All security vulnerabilities will be promptly addressed.

## License

Mason and the Laravel framework are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
