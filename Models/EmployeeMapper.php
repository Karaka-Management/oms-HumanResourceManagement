<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use Modules\Media\Models\MediaMapper;
use Modules\Profile\Models\ProfileMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Employe mapper class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
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
        'hr_staff_id'         => ['name' => 'hr_staff_id',       'type' => 'int',    'internal' => 'id'],
        'hr_staff_profile'    => ['name' => 'hr_staff_profile',  'type' => 'int',    'internal' => 'profile'],
        'hr_staff_smiPHash'   => ['name' => 'hr_staff_smiPHash', 'type' => 'string', 'internal' => 'semiPrivateHash'],
        'hr_staff_image'      => ['name' => 'hr_staff_image',    'type' => 'int',    'internal' => 'image', 'annotations' => ['gdpr' => true]],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:string, external:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
        'profile'    => [
            'mapper'     => ProfileMapper::class,
            'external'   => 'hr_staff_profile',
        ],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'image'    => [
            'mapper'     => MediaMapper::class,
            'external'   => 'hr_staff_image',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
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
            'mapper'       => EmployeeHistoryMapper::class,
            'table'        => 'hr_staff_history',
            'self'         => 'hr_staff_history_staff',
            'external'     => null,
        ],
        'workHistory' => [
            'mapper'       => EmployeeWorkHistoryMapper::class,
            'table'        => 'hr_staff_work_history',
            'self'         => 'hr_staff_work_history_staff',
            'external'     => null,
        ],
        'educationHistory' => [
            'mapper'       => EmployeeEducationHistoryMapper::class,
            'table'        => 'hr_staff_education_history',
            'self'         => 'hr_staff_education_history_staff',
            'external'     => null,
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
    public const PRIMARYFIELD ='hr_staff_id';
}
