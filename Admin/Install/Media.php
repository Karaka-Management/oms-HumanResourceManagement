<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Helper\HumanResourceManagement\Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Helper\HumanResourceManagement\Install;

use phpOMS\DataStorage\Database\DatabasePool;

/**
 * Media class.
 *
 * @package Modules\Helper\HumanResourceManagement\Install
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Media
{
    /**
     * Install media providing
     *
     * @param string       $path   Module path
     * @param DatabasePool $dbPool Database pool for database interaction
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function install(string $path, DatabasePool $dbPool) : void
    {
        \Modules\Media\HumanResourceManagement\Installer::installExternal($dbPool, ['path' => __DIR__ . '/Media.install.json']);
    }
}
