<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use Modules\HumanResourceManagement\Controller\BackendController;
use Modules\HumanResourceManagement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/humanresource/staff/list.*$' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::HR,
            ],
        ],
    ],
    '^.*/humanresource/staff/profile.*$' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffProfile',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::HR,
            ],
        ],
    ],
    '^.*/humanresource/staff/create.*$' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionState::HR,
            ],
        ],
    ],
    '^.*/humanresource/department/list.*$' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrDepartmentList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::DEPARTMENT,
            ],
        ],
    ],
    '^.*/humanresource/position/list.*$' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrPositionList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::POSITION,
            ],
        ],
    ],
    '^.*/humanresource/position/create.*$' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrPositionCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionState::POSITION,
            ],
        ],
    ],
];
