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

use Modules\Editor\Models\EditorDocMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Profile\Models\ProfileMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Employe mapper class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Employee
 * @extends DataMapperFactory<T>
 */
final class EmployeeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'hr_staff_id'       => ['name' => 'hr_staff_id',       'type' => 'int',    'internal' => 'id'],
        'hr_staff_status'  => ['name' => 'hr_staff_status',  'type' => 'int',    'internal' => 'status'],
        'hr_staff_profile'  => ['name' => 'hr_staff_profile',  'type' => 'int',    'internal' => 'profile'],
        'hr_staff_smiPHash' => ['name' => 'hr_staff_smiPHash', 'type' => 'string', 'internal' => 'semiPrivateHash', 'private' => true],
        'hr_staff_image'    => ['name' => 'hr_staff_image',    'type' => 'int',    'internal' => 'image', 'annotations' => ['gdpr' => true]],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:class-string, external:string, column?:string, by?:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
        'profile' => [
            'mapper'   => ProfileMapper::class,
            'external' => 'hr_staff_profile',
        ],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'image' => [
            'mapper'   => MediaMapper::class,
            'external' => 'hr_staff_image',
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
            'mapper'   => MediaMapper::class,       /* mapper of the related object */
            'table'    => 'hr_staff_media',         /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'hr_staff_media_media',
            'self'     => 'hr_staff_media_item',
        ],
        'companyHistory' => [
            'mapper'   => EmployeeHistoryMapper::class,
            'table'    => 'hr_staff_history',
            'self'     => 'hr_staff_history_staff',
            'external' => null,
        ],
        'workHistory' => [
            'mapper'   => EmployeeWorkHistoryMapper::class,
            'table'    => 'hr_staff_work_history',
            'self'     => 'hr_staff_work_history_staff',
            'external' => null,
        ],
        'educationHistory' => [
            'mapper'   => EmployeeEducationHistoryMapper::class,
            'table'    => 'hr_staff_education_history',
            'self'     => 'hr_staff_education_history_staff',
            'external' => null,
        ],
        'notes' => [
            'mapper'   => EditorDocMapper::class,       /* mapper of the related object */
            'table'    => 'hr_staff_note',         /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'hr_staff_note_doc',
            'self'     => 'hr_staff_note_staff',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'hr_staff';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'hr_staff_id';
}
