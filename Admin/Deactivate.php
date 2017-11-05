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
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);
namespace Modules\HumanResourceManagement\Admin;

use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\DeactivateAbstract;
use phpOMS\Module\InfoManager;

/**
 * Navigation class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Deactivate extends DeactivateAbstract
{

    /**
     * {@inheritdoc}
     */
    public static function deactivate(DatabasePool $dbPool, InfoManager $info)
    {
        parent::deactivate($dbPool, $info);
    }
}
