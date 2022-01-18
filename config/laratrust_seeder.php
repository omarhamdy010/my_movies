<?php

return [

    'create_users' => false,


    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'category' => 'c,r,u,d',
            'product' => 'c,r,u,d',
            'users' => 'c,r,u,d',
        ],
        'admin'=>[],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
