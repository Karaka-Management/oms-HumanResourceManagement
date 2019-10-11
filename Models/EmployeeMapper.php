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

use phpOMS\DataStorage\Database\DataMapperAbstract;
use Modules\Profile\Models\ProfileMapper;

/**
 * Employe mapper class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class EmployeeMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var   array<string, array<string, bool|string>>
     * @since 1.0.0
     */
    protected static array $columns = [
        'hr_staff_id'         => ['name' => 'hr_staff_id',       'type' => 'int',    'internal' => 'id'],
        'hr_staff_profile'    => ['name' => 'hr_staff_profile',  'type' => 'int',    'internal' => 'profile'],
        'hr_staff_smiPHash'   => ['name' => 'hr_staff_smiPHash', 'type' => 'string', 'internal' => 'semiPrivateHash'],
        'hr_staff_image'      => ['name' => 'hr_staff_image',    'type' => 'int',    'internal' => 'image', 'annotations' => ['gdpr' => true]],
    ];

    /**
     * Belongs to.
     *
     * @var   array<string, array<string, string>>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
        'profile'    => [
            'mapper' => ProfileMapper::class,
            'src'    => 'hr_staff_profile',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var   array<string, array<string, null|string>>
     * @since 1.0.0
     */
    protected static array $hasMany = [
        'companyHistory' => [
            'mapper' => EmployeeHistoryMapper::class,
            'table'  => 'hr_staff_history',
            'dst'    => 'hr_staff_history_staff',
            'src'    => null,
        ],
    ];

    /**
     * Primary table.
     *
     * @var   string
     * @since 1.0.0
     */
    protected static string $table = 'hr_staff';

    /**
     * Primary field name.
     *
     * @var   string
     * @since 1.0.0
     */
    protected static string $primaryField = 'hr_staff_id';
}
