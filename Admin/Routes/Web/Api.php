<?php
/**
 * Karaka
 *
 * PHP Version 8.1
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
    '^.*/humanresource/staff.*$' => [
        [
            'dest'       => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::HR,
            ],
        ],
    ],
];
