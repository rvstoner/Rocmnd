<?php

return [
    'role_structure' => [
        'server_administrator' => [
            'profile' => 'c,r,u',
            'facilities' => 'c,r,u,d',
            'serveradministrator' => 'c,r,u,d',
            'payrollmanager' => 'c,r,u,d',
            'director' => 'c,r,u,d',
            'assistantdirector' => 'c,r,u,d',
            'administrator' => 'c,r,u,d',
            'supervisor' => 'c,r,u,d',
            'parttimesupervisor' => 'c,r,u,d',
            'fulltime' => 'c,r,u,d',
            'parttime' => 'c,r,u,d',
            'users' => 'c,r,u,d'
        ],
        'payroll_manager' => [
            'profile' => 'c,r,u',
            'facilities' => 'c,r,u,d',
            'serveradministrator' => 'r',
            'payrollmanager' => 'c,r,u,d',
            'director' => 'c,r,u,d',
            'assistantdirector' => 'c,r,u,d',
            'administrator' => 'c,r,u,d',
            'supervisor' => 'c,r,u,d',
            'parttimesupervisor' => 'c,r,u,d',
            'fulltime' => 'c,r,u,d',
            'parttime' => 'c,r,u,d',
            'users' => 'c,r,u,d'
        ],
        'director' => [
            'profile' => 'c,r,u',            
            'facilities' => 'r',
            'serveradministrator' => 'r',
            'payrollmanager' => 'r',
            'director' => 'r,u',
            'assistantdirector' => 'c,r,u,d',
            'administrator' => 'c,r,u,d',
            'supervisor' => 'c,r,u,d',
            'parttimesupervisor' => 'c,r,u,d',
            'fulltime' => 'c,r,u,d',
            'parttime' => 'c,r,u,d',
            'users' => 'c,r,u,d'
        ],
        'assistant_director' => [
            'profile' => 'c,r,u',
            'facilities' => 'r',
            'serveradministrator' => 'r',
            'payrollmanager' => 'r',
            'director' => 'r',
            'assistantdirector' => 'r,u',
            'administrator' => 'c,r,u,d',
            'supervisor' => 'c,r,u,d',
            'parttimesupervisor' => 'c,r,u,d',
            'fulltime' => 'c,r,u,d',
            'parttime' => 'c,r,u,d',
            'users' => 'c,r,u,d'
        ],
        'administrator' => [
            'profile' => 'c,r,u',
            'facilities' => 'r',
            'serveradministrator' => 'r',
            'payrollmanager' => 'r',
            'director' => 'r',
            'assistantdirector' => 'r',
            'administrator' => 'r,u',
            'supervisor' => 'c,r,u,d',
            'parttimesupervisor' => 'c,r,u,d',
            'fulltime' => 'c,r,u,d',
            'parttime' => 'c,r,u,d',
            'users' => 'c,r,u,d'
        ],
        'supervisor' => [
            'profile' => 'r,u',
            'facilities' => 'r',
            'serveradministrator' => 'r',
            'payrollmanager' => 'r',
            'director' => 'r',
            'assistantdirector' => 'r,',
            'administrator' => 'r,',
            'supervisor' => 'r,u',
            'parttimesupervisor' => 'r,u',
            'fulltime' => 'r,u',
            'parttime' => 'r,u'
        ],
        'parttimesupervisor' => [
            'profile' => 'r,u',
            'facilities' => 'r',
            'serveradministrator' => 'r',
            'payrollmanager' => 'r',
            'director' => 'r',
            'assistantdirector' => 'r',
            'administrator' => 'r',
            'supervisor' => 'r',
            'parttimesupervisor' => 'r',
            'fulltime' => 'r,u',
            'parttime' => 'r,u'
        ],
        'fulltime' => [
            'profile' => 'r,u',
            'facilities' => 'r',
            'serveradministrator' => 'r',
            'payrollmanager' => 'r',
            'director' => 'r',
            'assistantdirector' => 'r',
            'administrator' => 'r',
            'supervisor' => 'r',
            'fulltime' => 'r,u',
            'parttime' => 'r'
        ],
        'parttime' => [
            'profile' => 'r,u',
            'facilities' => 'r',
            'serveradministrator' => 'r',
            'payrollmanager' => 'r',
            'director' => 'r',
            'assistantdirector' => 'r',
            'administrator' => 'r',
            'supervisor' => 'r',
            'fulltime' => 'r',
            'parttime' => 'r,u'
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
