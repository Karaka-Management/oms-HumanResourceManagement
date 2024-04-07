<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\HumanResourceManagement\Controller\BackendController;
use Modules\HumanResourceManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/humanresource/staff/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
    '^/humanresource/staff/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffView',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
    '^/humanresource/staff/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrStaffCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
    '^/humanresource/department/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrDepartmentList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::DEPARTMENT,
            ],
        ],
    ],
    '^/humanresource/department/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrDepartmentView',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::DEPARTMENT,
            ],
        ],
    ],
    '^/humanresource/position/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrPositionList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::POSITION,
            ],
        ],
    ],
    '^/humanresource/position/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\BackendController:viewHrPositionView',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::POSITION,
            ],
        ],
    ],
];
