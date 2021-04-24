<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * EmployeHistory mapper class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class EmployeeEducationHistoryMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
        'hr_staff_education_history_id'           => ['name' => 'hr_staff_education_history_id',         'type' => 'int',      'internal' => 'id'],
        'hr_staff_education_history_staff'        => ['name' => 'hr_staff_education_history_staff',      'type' => 'int',      'internal' => 'employee'],
        'hr_staff_education_history_address'      => ['name' => 'hr_staff_education_history_address',      'type' => 'Serializable',      'internal' => 'address'],
        'hr_staff_education_history_title'        => ['name' => 'hr_staff_education_history_title',      'type' => 'string',      'internal' => 'educationTitle'],
        'hr_staff_education_history_passed'       => ['name' => 'hr_staff_education_history_passed',      'type' => 'bool',      'internal' => 'passed'],
        'hr_staff_education_history_score'        => ['name' => 'hr_staff_education_history_score',      'type' => 'string',      'internal' => 'score'],
        'hr_staff_education_history_start'        => ['name' => 'hr_staff_education_history_start',      'type' => 'DateTime', 'internal' => 'start'],
        'hr_staff_education_history_end'          => ['name' => 'hr_staff_education_history_end',        'type' => 'DateTime', 'internal' => 'end'],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:string, external:string}>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
        'employee'    => [
            'mapper'     => EmployeeMapper::class,
            'external'   => 'hr_staff_education_history_staff',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    protected static array $hasMany = [
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
    protected static string $primaryField = 'hr_staff_education_history_id';

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'hr_staff_education_history';
}
