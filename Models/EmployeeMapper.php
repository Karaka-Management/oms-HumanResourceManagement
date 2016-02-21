<?php
/**
 * Orange Management
 *
 * PHP Version 7.0
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Modules\Admin\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;

class EmployeeMapper extends AccountMapper
{

    /**
     * Columns.
     *
     * @var array<string, array>
     * @since 1.0.0
     */
    protected static $columns = [
        'hr_staff_id'         => ['name' => 'account_id', 'type' => 'int', 'internal' => 'id'],
        'hr_staff'     => ['name' => 'account_status', 'type' => 'int', 'internal' => 'status'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'hr_staff';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'hr_staff_id';

    /**
     * Overwriting extended
     *
     * @var bool
     * @since 1.0.0
     */
    protected static $overwrite = false;
}
