<?php declare(strict_types=1);

use Modules\HumanResourceManagement\Controller\BackendController;
use Modules\HumanResourceManagement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/hr/staff/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffList',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::HR,
            ],
        ],
    ],
    '^.*/hr/staff/profile.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffProfile',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::HR,
            ],
        ],
    ],
    '^.*/hr/staff/create.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffCreate',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::CREATE,
                'state' => PermissionState::HR,
            ],
        ],
    ],
    '^.*/hr/department/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrDepartmentList',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::DEPARTMENT,
            ],
        ],
    ],
];
