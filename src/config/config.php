<?php

return [

    /*
     * Database table config
     */
    'database' => [
        'tables' => [
            //'role' => 'tableName'
            'role'                       => 'roles',
            'permission'                 => 'permissions',
            'role_permission_relation'   => 'role_permission',
            'user_role_relation'         => 'user_role'
        ],
    ],

    /*
     * Role, Permission model config
     */
    'model' => [
        'role'       => Zjien\Quantum\Models\Role::class,
        'permission' => Zjien\Quantum\Models\Permission::class,
    ],


];