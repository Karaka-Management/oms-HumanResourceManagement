<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Employee status enum.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class EmployeeStatus extends Enum
{
    public const ACTIVE = 1;

    public const INACTIVE = 2;

    public const UNAVAILABLE = 3;
}
