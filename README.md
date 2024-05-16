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

```
php artisan db:seed --class=DatabaseSeeder
```
To create the project's Permissions, roles and Super Admin user.

> [!NOTE]
> _Obviously and not explicitly, the mysql service must be running and with the database defined in its .env created._

## Examples
Admin Panel                |  Edit Role Permissions
:-------------------------:|:-------------------------:
![Image of the admin panel to edit roles created in the system.](/public/assets/images/readme_image_1.jpg)   |  ![Image of the admin panel when editing permissions linked to a role.](/public/assets/images/readme_image_2.jpg)

## Usage

### Creating new Permissions

In the `PermissionSeeder.php` file you can see the permissions set by default. The permissions are distributed in groups, groups that will set up the structure to display the permissions when editing a role.

```
$logs = Group::firstOrCreate([
            'name' => 'Log'
]);

Permission::firstOrCreate([ //13
    'group_id' => $logs->id,
    'name' => 'log-view',
    'display_name' => 'Visualizar Log'
]);
```

Above we have an example of creating a group with a permission that belongs to this group. If necessary, you can create another group and enter the `parent_id` field of the Model `Group`, making it become a subgroup:

```
$admins = Group::firstOrCreate([
    'name' => 'Admin'
]);

$adminPanel = Group::firstOrCreate([
    'name' => 'Admin Panel',
    'parent_id' => $admins->id
]);

Permission::firstOrCreate([ //15
    'group_id' => $adminPanel->id,
    'name' => 'admin-panel',
    'display_name' => 'Panel Admin'
]);
```
Now the `Admin Panel` group is a subgroup of the `Admin` group.

### Creating new Roles

In the `RoleSeeder.php` file you can see the default roles already created and the moment at which they are synchronized (**Many to Many Relationship**). Just add or edit roles and synchronize with the permissions you want.

```
$superAdminRole = Role::firstOrCreate(['id' => 1, 'name' => 'Super Admin']);
$adminRole = Role::firstOrCreate(['id' => 2, 'name' => 'Admin']);
$employeeRole = Role::firstOrCreate(['id' => 3, 'name' => 'Funcionário']);

$allPermissions = Permission::all()->pluck('id');

$superAdminRole->permissions()->sync($allPermissions);
$adminRole->permissions()->sync([1,2,3,4,5,6,7,8,9,10,11,13,15]);
```
If you wish, you can not synchronize the permissions at this time and just add them later in the Admin panel.

> [!IMPORTANT]
> In the `UserSeeder.php file` you will find the system's 'Super Admin' user to start using, but if you prefer you can just register a new user. (_New users are registered with the 'Admin'_ profile).

## License

The Laravel-Base Project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
