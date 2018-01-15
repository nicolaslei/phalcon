<?php

return [
    'default' => env('ACL_SCHEMA_DRIVER', 'database'),
    'drivers' => [
        'database' => [
            'adapter' => 'Database',
        ],
        'redis'    => [
            'adapter' => 'Redis',
        ],
        'mongo'    => [
            'adapter' => 'Mongo',
        ],
        'memory'   => [
            'alcFilePath' => config_path('acl.php')
        ],
    ],
    'schemas'  => [
        'roles'             => env('ACL_SCHEMA_ROLES', 'roles'),
        'rolesInherits'     => env('ACL_SCHEMA_ROLESINHERITS', 'roles_inherits'),
        'resources'         => env('ACL_SCHEMA_RESOURCES', 'resources'),
        'resourcesAccesses' => env('ACL_SCHEMA_RESOURCESACCESSES', 'resources_accesses'),
        'accessList'        => env('ACL_SCHEMA_ACCESSLIST', 'access_list')
    ]
];