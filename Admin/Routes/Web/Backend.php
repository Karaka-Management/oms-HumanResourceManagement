<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/hr/staff/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/hr/staff/create.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/hr/department/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrDepartmentList', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
