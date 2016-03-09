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

class EmployeeMapper
{

    /**
     * Columns.
     *
     * @var array<string, array>
     * @since 1.0.0
     */
    protected static $columns = [
        'hr_staff_id'         => ['name' => 'hr_staff_id', 'type' => 'int', 'internal' => 'id'],
        'hr_staff'     => ['name' => 'hr_staff', 'type' => 'int', 'internal' => 'account'],
    ];

    protected static $ownsOne = [
        'account' => [
            'mapper'         => \Modules\Admin\Models\AccountMapper::class,
            'src'            => 'hr_staff',
        ],
    ];

    protected static $hasMany = [
        'history' => [
            'mapper' => \Modules\HumanResourceManagement\Models\EmployeeHistoryMapper::class,
            'relationmapper' => \Modules\HumanResourceManagement\Models\EmployeeHistoryMapper::class,
            'table' => 'hr_history',
            'src' => 'hr_history_staff',
            'dst' => null,
        ],
        'status' => [
            'mapper' => \Modules\HumanResourceManagement\Models\EmployeeStatus::class,
            'relationmapper' => \Modules\HumanResourceManagement\Models\EmployeeStatus::class,
            'table' => 'hr_status',
            'src' => 'hr_status_staff',
            'dst' => null,
        ],
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
}
