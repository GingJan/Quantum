<?php

return [

    /*
     * Database table Config
     */
    'database' => [
        'tables' => [
            //'role' => 'tableName'
            'role'                       => 'roles',
            'permission'                 => 'permissions',
            'role_permission_relation'   => 'role_permission',
            'user_role_relation'         => 'user_role'
        ],

        'fields' => [
            'owner' => 'owner_id',
        ]


    ],

    /*
     * Model Config
     */
    'model' => [
        'role'       => Zjien\Quantum\Models\Role::class,
        'permission' => Zjien\Quantum\Models\Permission::class,
    ],

    /*
     * Cache Config
     */
    'cache' => [
        /*
         * Enable or disable cache
         */
        'enabled' => true,

        /*
         * Time of expiration cache (minutes)
         */
        'minutes' => 60,
    ]
];