<?php declare(strict_types=1);

use Modules\HumanResourceManagement\Controller\ApiController;
use Modules\HumanResourceManagement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/humanresource/staff.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller\ApiController:apiEmployeeCreate',
            'verb' => RouteVerb::PUT,
            'permission' => [
                'module' => ApiController::MODULE_NAME,
                'type'  => PermissionType::CREATE,
                'state' => PermissionState::HR,
            ],
        ],
    ],
];