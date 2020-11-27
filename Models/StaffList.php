<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;

/**
 * Staff list class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class StaffList
{
    /**
     * Database instance.
     *
     * @var DatabasePool
     * @since 1.0.0
     */
    private DatabasePool $dbPool;

    /**
     * Constructor.
     *
     * @param DatabasePool $dbPool Database pool instance
     *
     * @since 1.0.0
     */
    public function __construct(DatabasePool $dbPool)
    {
        $this->dbPool = $dbPool;
    }

    /**
     * Get all staff members.
     *
     * This function gets all accounts in a range
     *
     * @param array $filter Filter for search results
     * @param int   $offset Offset for first account
     * @param int   $limit  Limit for results
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function getList($filter = null, $offset = 0, $limit = 100) : array
    {
        $result = [];

        return $result;
    }

    /**
     * Get task stats.
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function getStats() : array
    {
        return [];
    }
}
