<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\tests\HumanResourceManagement\Models;

use Modules\HumanResourceManagement\Models\Employee;

/**
 * @internal
 */
class EmployeeTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault() : void
    {
        $employee = new Employee();

        self::assertEquals(0, $employee->getId());
        self::assertGreaterThan(0, \strlen($employee->getSemiPrivateHash()));
        self::assertFalse($employee->compareSemiPrivateHash('123'));
        self::assertInstanceOf('\Modules\Media\Models\NullMedia', $employee->getImage());
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\NullEmployeeHistory', $employee->getNewestHistory());
        self::assertEquals([], $employee->getHistory());
        self::assertEquals([], $employee->getEducationHistory());
        self::assertEquals([], $employee->getWorkHistory());
    }
}
