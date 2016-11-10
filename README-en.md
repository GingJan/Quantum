# Quantum 
Quantum is a RBAC package based on RESTful API for Laravel.

## Contents
- [Installation](#installation)
- 


## Installation
1) Run this command in your command line:
`composer require zjien/quantum`
and then wait for seconds.

2) When it finish.Edit your `config/app.php` adding the following to the `providers` array:
```php
Zjien\Quantum\Providers\QuantumServiceProvider::class,
```
and adding the following to the `aliases` array:
```php
'Quantum' => Zjien\Quantum\Facades\QuantumFacade::class,
```

3) Run the following command to publish the Quantum config file.
```shell
php artisan vendor:publish
```

## Configuration
1) Run the following command to generate the Quantum migrations.
```shell
php artisan quantum:migration
```
It will generate and put the quantum migrations to your migrations directory.

2) Set the property in the `config/quantum.php`

### Extends the Quantum Models
#### Role
Create a Role model inside `app/models/Role.php` using the following example:

```php
<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
}
```
#### Permission

#### User



