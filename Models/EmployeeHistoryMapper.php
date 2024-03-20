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

use Modules\Media\Models\MediaMapper;
use Modules\Organization\Models\DepartmentMapper;
use Modules\Organization\Models\PositionMapper;
use Modules\Organization\Models\UnitMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * EmployeHistory mapper class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of EmployeeHistory
 * @extends DataMapperFactory<T>
 */
final class EmployeeHistoryMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'hr_staff_history_id'         => ['name' => 'hr_staff_history_id',         'type' => 'int',      'internal' => 'id'],
        'hr_staff_history_staff'      => ['name' => 'hr_staff_history_staff',      'type' => 'int',      'internal' => 'employee'],
        'hr_staff_history_unit'       => ['name' => 'hr_staff_history_unit',       'type' => 'int',      'internal' => 'unit'],
        'hr_staff_history_department' => ['name' => 'hr_staff_history_department', 'type' => 'int',      'internal' => 'department'],
        'hr_staff_history_position'   => ['name' => 'hr_staff_history_position',   'type' => 'int',      'internal' => 'position'],
        'hr_staff_history_start'      => ['name' => 'hr_staff_history_start',      'type' => 'DateTime', 'internal' => 'start'],
        'hr_staff_history_end'        => ['name' => 'hr_staff_history_end',        'type' => 'DateTime', 'internal' => 'end'],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:class-string, external:string, column?:string, by?:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
        'unit' => [
            'mapper'   => UnitMapper::class,
            'external' => 'hr_staff_history_unit',
        ],
        'department' => [
            'mapper'   => DepartmentMapper::class,
            'external' => 'hr_staff_history_department',
        ],
        'position' => [
            'mapper'   => PositionMapper::class,
            'external' => 'hr_staff_history_position',
        ],
        'employee' => [
            'mapper'   => EmployeeMapper::class,
            'external' => 'hr_staff_history_staff',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'files' => [
            'mapper'   => MediaMapper::class,            /* mapper of the related object */
            'table'    => 'hr_staff_work_history_media',         /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'hr_staff_work_history_media_media',
            'self'     => 'hr_staff_work_history_media_history',
        ],
    ];

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'hr_staff_history_id';

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'hr_staff_history';
}
