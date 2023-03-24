<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\tests\Models;

use Modules\Admin\Models\AccountMapper;
use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\Profile\Models\Profile;
use Modules\Profile\Models\ProfileMapper;

/**
 * @internal
 */
final class EmployeeMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeMapper
     * @group module
     */
    public function testCR() : void
    {
        if (($profile = ProfileMapper::get()->where('account', 1)->execute())->getId() === 0) {
            $profile = new Profile();

            $profile->account  = AccountMapper::get()->where('id', 1)->execute();
            $profile->birthday = ($date = new \DateTime('now'));

            $id = ProfileMapper::create()->execute($profile);
        }

        $employee = new Employee($profile);

        $id = EmployeeMapper::create()->execute($employee);
        self::assertGreaterThan(0, $employee->getId());
        self::assertEquals($id, $employee->getId());

        $employeeR = EmployeeMapper::get()->where('id', $employee->getId())->execute();
        self::assertEquals($employee->profile->getId(), $employeeR->profile->getId());
        self::assertGreaterThan(0, EmployeeMapper::get()->with('profile')->where('profile/account', 1)->limit(1)->execute()->getId());
    }
}
