<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types=1);
namespace Modules\HumanResourceManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Position type enum.
 *
 * @category   Module
 * @package    Modules\HumanResources
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class PositionType extends Enum
{
    /* public */ const INTERN = 0;

    /* public */ const APPRENTICE = 1;

    /* public */ const JUNIOR = 2;

    /* public */ const REGULAR = 3;

    /* public */ const SENIOR = 4;

    /* public */ const ASSISTANT = 5;

    /* public */ const TEAMLEADER = 6;

    /* public */ const HEAD = 7;
}
