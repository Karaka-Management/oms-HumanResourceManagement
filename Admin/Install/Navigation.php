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
namespace Modules\HumanResourceManagement\Admin\Install;
use phpOMS\DataStorage\Database\DatabasePool;

/**
 * Navigation class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Navigation
{
    public static function install(string $path, DatabasePool $dbPool)
    {
        $navData = json_decode(file_get_contents(__DIR__ . '/Navigation.install.json'), true);

        $class = '\\Modules\\Navigation\\Admin\\Installer';
        /** @var $class \Modules\Navigation\Admin\Installer */
        $class::installExternal($dbPool, $navData);
    }
}
