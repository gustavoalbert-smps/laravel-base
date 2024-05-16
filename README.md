<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel-Base

Laravel-Base is an application made with Laravel 10, with the aim of speeding up and facilitating the creation of ACL (User Access Control) in new projects. The project already provides the necessary structure so that you can configure the roles and permissions for your business idea. Allowing you to save time and start developing the specific functionalities of your application.

## Installation

### Required

- PHP ^8.1
- Composer
- NPM ^9
- MySQL (Or change laravel settings to run on your preferred DB)

## Commands

### Installation
```
npm install
```
to install the components used by Livewire with Volt.

```
composer install
```
to install the Laravel project and its dependencies.

### To run the Application
```
npm run dev
```
to run vite and load the Livewire and Volt components.

```
php artisan serve
```
to run the Laravel application.

> [!NOTE]
> _Obviously and not explicitly, the mysql service must be running and with the database defined in its .env created._

## Examples

![Image of the admin panel to edit roles created in the system.](/public/assets/images/readme_image_1.jpg)
![Image of the admin panel when editing permissions linked to a role.](/public/assets/images/readme_image_2.jpg)

## License

The Laravel-Base Project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
