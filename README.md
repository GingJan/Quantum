# Quantum
Quantum是个基于RESTful API的RBAC Laravel扩展包

## Contents
- [安装](#安装)
- [配置](#配置)
- [使用](#使用)


## 安装
1) 在终端输入下面命令:
`composer require zjien/quantum`
然后稍等几分钟。

2) 当composer下载并安装完成后。编辑 `config/app.php` 文件，添加下面代码到 `providers` 数组里：
```php
Zjien\Quantum\Providers\QuantumServiceProvider::class,
```

然后添加下列代码到 `aliases` 数组里：
```php
'Quantum' => Zjien\Quantum\Facades\QuantumFacade::class,
```

3) 在终端运行下面命令，复制Quantum的配置文件到你项目的配置目录中。
```shell
php artisan vendor:publish
```

## 配置
1) 运行下面命令，生成Quantum的迁移文件。
```shell
php artisan quantum:migration
```
该命令会生成Quantum的迁移文件到你项目的迁移目录中。

2) 在 `config/quantum.php` 配置文件设置相应的配置信息。

### 继承 Quantum 的 Models
#### Role
创建你自己的 Role 模型（或者直接使用Quantum的），并继承 Quantum 的 Role 模型：
```php
<?php namespace App;

use Zjien\Quantum\Models\Role as QuantumRole;

class Role extends QuantumRole
{
    //your code goes here
}
```

#### Permission
创建你自己的 Permission 模型（或者直接使用Quantum的），并继承 Quantum 的 Permission 模型：
```php
<?php namespace App;

use Zjien\Quantum\Models\Permission as QuantumPermission;

class Permission extends QuantumPermission
{
    //your code goes here
}
```

#### User
创建你自己的 User 模型（或者直接使用Quantum的），并继承 Quantum 的 User 模型：
```php
<?php namespace App;

use Zjien\Quantum\Models\User as QuantumUser;

class User extends QuantumUser
{
    //your code goes here
}
```

接着运行以下命令：
```shell
composer dump-autoload
```

## 使用
### 创建角色
```php
$role['name'] = 'admin';
$role['display_name'] = 'Platform Admin';
$role['description'] = 'the platform admin';
$role = (new Role())->create($role);
```

### 创建权限
```php
$perm['name'] = 'create-admin';
$perm['verb'] = 'POST';
$perm['uri'] = '/admins';
$perm['display_name'] = 'Create Amin';
$perm['description'] = 'the permission to create a admin account';
$perm = (new Permission())->create($perm);
```

### 为角色增添权限
```php
$role->attachPermission($perm);
$role->attachPermission([1,2,3]);//1,2,3为权限对应的id
$role->attachPermission(1);//添加权限id为1的权限
```

### 为用户增添角色
```php
$user->attachRole($role);
$user->attachRole([1,2,3]);//1,2,3为角色对应的id
$user->attachRole(1);//添加角色id为1的角色
```

### 判断用户是否拥有某权限
$role = Role::find(1);
$user->is($role);//判断用户是否拥有某个角色
$perm = Permission::find(2);
$user->can($perm);//判断用户是否有某个权限

`is` 和 `can` 都可以传入一个对象数组
$role = Role::find([1,2]);
$user->is($role, true);//要求用户拥有所有角色才有效
$perm = Permission::find([1,2]);
$user->can($perm);//判断用户是否有多个权限中的某个

### 中间件
使用中间验证请求资源的用户是否具有访问该资源的权限
在 `app/Http/Kernel.php`的 `routeMiddleware` 数组中添加如下代码：
```php
'permission_check' => \Zjien\Quantum\Middleware\QuantumAccess::class,
```
