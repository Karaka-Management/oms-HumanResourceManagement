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

use Modules\HumanResourceManagement\Controller\ApiController;
use Modules\HumanResourceManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/humanresource/staff(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'active' => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
    '^.*/humanresource/staff/history(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeHistoryCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'active' => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::HR,
            ],
        ],
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeHistoryUpdate',
            'verb'       => RouteVerb::SET,
            'csrf'       => true,
            'active' => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::MODIFY,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
    '^.*/humanresource/staff/work(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeWorkHistoryCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'active' => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::HR,
            ],
        ],
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeWorkHistoryUpdate',
            'verb'       => RouteVerb::SET,
            'csrf'       => true,
            'active' => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::MODIFY,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
    '^.*/humanresource/staff/education(\?.*$|$)' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeEducationHistoryCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'active' => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::HR,
            ],
        ],
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeEducationHistoryUpdate',
            'verb'       => RouteVerb::SET,
            'csrf'       => true,
            'active' => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::MODIFY,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
];
