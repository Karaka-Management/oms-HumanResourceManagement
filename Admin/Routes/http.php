<?php

$httpRoutes = [
    '^.*/backend/hr/staff/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrList', 
            'verb' => RouteVerb::GET,
            'result' => ViewType::HTML,
            'layout' => ViewLayout::MAIN,
        ],
    ],
    '^.*/backend/hr/staff/create.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrCreate', 
            'verb' => RouteVerb::GET,
            'result' => ViewType::HTML,
            'layout' => ViewLayout::MAIN,
        ],
    ],
    '^.*/backend/hr/department/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrDepartmentList', 
            'verb' => RouteVerb::GET,
            'result' => ViewType::HTML,
            'layout' => ViewLayout::MAIN,
        ],
    ],
];
