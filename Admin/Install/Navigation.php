<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Modules\HumanResourceManagement\Admin\Install
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Admin\Install;

use phpOMS\DataStorage\Database\DatabasePool;

/**
 * Navigation class.
 *
 * @package    Modules\HumanResourceManagement\Admin\Install
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Navigation
{
    /**
     * Install navigation providing
     *
     * @param string       $path   Path to some file
     * @param DatabasePool $dbPool Database pool for database interaction
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function install(string $path = null, DatabasePool $dbPool = null) : void
    {
        $navData = \json_decode(file_get_contents(__DIR__ . '/Navigation.install.json'), true);

        $class = '\\Modules\\Navigation\\Admin\\Installer';
        /** @var $class \Modules\Navigation\Admin\Installer */
        $class::installExternal($dbPool, $navData);
    }
}
