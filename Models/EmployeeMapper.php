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

use Modules\Admin\Models\AccountMapper;
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
     * @var array<string, array{mapper:string, self:string}>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
        'profile'    => [
            'mapper' => ProfileMapper::class,
            'self'   => 'hr_staff_profile',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    protected static array $hasMany = [
        'companyHistory' => [
            'mapper' => EmployeeHistoryMapper::class,
            'table'  => 'hr_staff_history', // @todo: is this requried? This is stored in the mapper already. In other places I'm not using this, either use it everywhere or nowhere. Using the mapper is slower but protects us from table name changes!
            'external' => 'hr_staff_history_staff',
            'self'   => null,
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
        $query = new Builder(self::$db);
        $query->select(self::$table . '.*')
            ->from(self::$table)
            ->innerJoin(ProfileMapper::getTable())
                ->on(self::$table . '.hr_staff_profile', '=', ProfileMapper::getTable() . '.' . ProfileMapper::getPrimaryField())
            ->innerJoin(AccountMapper::getTable())
                ->on(ProfileMapper::getTable() . '.profile_account_account', '=', AccountMapper::getTable() . '.' . AccountMapper::getPrimaryField())
            ->where(AccountMapper::getTable() . '.' . AccountMapper::getPrimaryField(), '=', $account)
            ->limit(1);

        $employee = self::getAllByQuery($query);

        return empty($employee) ? new NullEmployee() : \end($employee);
    }
}
