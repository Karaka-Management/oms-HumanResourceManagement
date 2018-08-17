<?php

use phpOMS\Router\RouteVerb;
use phpOMS\Account\PermissionType;
use Modules\HumanResourceManagement\Models\PermissionState;
use Modules\HumanResourceManagement\Controller;

return [
    '^.*/backend/hr/staff/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrStaffList',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => Controller::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::HR,
            ],
        ],
    ],
    '^.*/backend/hr/staff/profile.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrStaffProfile',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => Controller::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::HR,
            ],
        ],
    ],
    '^.*/backend/hr/staff/create.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrStaffCreate',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => Controller::MODULE_NAME,
                'type'  => PermissionType::CREATE,
                'state' => PermissionState::HR,
            ],
        ],
    ],
    '^.*/backend/hr/department/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrDepartmentList',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => Controller::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::DEPARTMENT,
            ],
        ],
    ],
];
