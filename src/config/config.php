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

    'service' => [
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
        ],

        /*
         * Repository Config
         */
        'repository' => [
            /*
             * Enable or disable cache
             */
            'enabled' => true,
            /*
             * mapping config
             */
            'mapping' => [
//        'resource' => 'repository'
                'articles' => Zjien\QuantumDemo\Repositories\ArticleRepository::class,
            ],

        ],

    ],

    /*
     * Resource Config
     * Ex. articles resource mapping to app\Models\Article model.
     */
    'resource' => [
//        'alias' => 'abstract'
//        'articles' => Zjien\QuantumDemo\Models\Article::class,
    ],

    /*
     * Role, Permission Model Config
     */
    'model' => [
        'role'       => Zjien\Quantum\Models\Role::class,
        'permission' => Zjien\Quantum\Models\Permission::class,
    ],


];