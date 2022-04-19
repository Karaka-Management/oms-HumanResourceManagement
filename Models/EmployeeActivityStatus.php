<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Employee activity status enum.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
abstract class EmployeeActivityStatus extends Enum
{
    public const ACTIVE = 1;

    public const INACTIVE = 2;
}
