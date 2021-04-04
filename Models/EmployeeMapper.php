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

use Modules\Admin\Models\AccountMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Profile\Models\ProfileMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;

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
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
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
     * @var array<string, array{mapper:string, external:string}>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
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
    protected static array $ownsOne = [
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
    protected static array $hasMany = [
        'files' => [
            'mapper'   => MediaMapper::class,            /* mapper of the related object */
            'table'    => 'hr_staff_media',         /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'hr_staff_media_media',
            'self'     => 'hr_staff_media_item',
        ],
        'companyHistory' => [
            'mapper'       => EmployeeHistoryMapper::class,
            'table'        => 'hr_staff_history', // @todo: is this requried? This is stored in the mapper already. In other places I'm not using this, either use it everywhere or nowhere. Using the mapper is slower but protects us from table name changes!
            'self'         => 'hr_staff_history_staff',
            'external'     => null,
        ],
        'workHistory' => [
            'mapper'       => EmployeeWorkHistoryMapper::class,
            'table'        => 'hr_staff_work_history', // @todo: is this requried? This is stored in the mapper already. In other places I'm not using this, either use it everywhere or nowhere. Using the mapper is slower but protects us from table name changes!
            'self'         => 'hr_staff_work_history_staff',
            'external'     => null,
        ],
        'educationHistory' => [
            'mapper'       => EmployeeEducationHistoryMapper::class,
            'table'        => 'hr_staff_education_history', // @todo: is this requried? This is stored in the mapper already. In other places I'm not using this, either use it everywhere or nowhere. Using the mapper is slower but protects us from table name changes!
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
    protected static string $table = 'hr_staff';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'hr_staff_id';

    /**
     * Get the employee from an account
     *
     * @param int $account Account to get the employee for
     *
     * @return Employee
     *
     * @since 1.0.0
     */
    public static function getFromAccount(int $account) : Employee
    {
        $depth = 3;
        $query = new Builder(self::$db);
        $query = self::getQuery($query)
            ->innerJoin(ProfileMapper::getTable())
                ->on(self::$table . '_' . $depth . '.hr_staff_profile', '=', ProfileMapper::getTable() . '.' . ProfileMapper::getPrimaryField())
            ->innerJoin(AccountMapper::getTable())
                ->on(ProfileMapper::getTable() . '.profile_account_account', '=', AccountMapper::getTable() . '.' . AccountMapper::getPrimaryField())
            ->where(AccountMapper::getTable() . '.' . AccountMapper::getPrimaryField(), '=', $account)
            ->limit(1);

        $employee = self::getAllByQuery($query);

        return empty($employee) ? new NullEmployee() : \end($employee);
    }
}
