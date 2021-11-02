<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\tests\Models;

use Modules\Profile\Models\Profile;
use Modules\Profile\Models\NullProfile;
use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeWorkHistory;
use Modules\HumanResourceManagement\Models\EmployeeEducationHistory;

/**
 * @internal
 */
final class EmployeeTest extends \PHPUnit\Framework\TestCase
{
    private Employee $employee;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->employee = new Employee();
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\Employee
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->employee->getId());
        self::assertGreaterThan(0, \strlen($this->employee->getSemiPrivateHash()));
        self::assertFalse($this->employee->compareSemiPrivateHash('123'));
        self::assertInstanceOf('\Modules\Media\Models\NullMedia', $this->employee->image);
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\NullEmployeeHistory', $this->employee->getNewestHistory());
        self::assertEquals([], $this->employee->getHistory());
        self::assertEquals([], $this->employee->getEducationHistory());
        self::assertEquals([], $this->employee->getWorkHistory());
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\Employee
     * @group module
     */
    public function testPrivateHashInputOutput() : void
    {
        $temp = $this->employee->getSemiPrivateHash();
        self::assertTrue($this->employee->compareSemiPrivateHash($temp));
        $this->employee->updateSemiPrivateHash();
        self::assertFalse($this->employee->compareSemiPrivateHash($temp));
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\Employee
     * @group module
     */
    public function testHistoryInputOutput() : void
    {
        $this->employee->addHistory($a = new EmployeeHistory());
        $this->employee->addHistory($b = new EmployeeHistory());
        self::assertCount(2, $this->employee->getHistory());
        self::assertEquals($b, $this->employee->getNewestHistory());
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\Employee
     * @group module
     */
    public function testWorkHistoryInputOutput() : void
    {
        $this->employee->addWorkHistory($a = new EmployeeWorkHistory());
        $this->employee->addWorkHistory($b = new EmployeeWorkHistory());
        self::assertCount(2, $this->employee->getWorkHistory());
        self::assertEquals($b, $this->employee->getNewestWorkHistory());
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\Employee
     * @group module
     */
    public function testEducationHistoryInputOutput() : void
    {
        $this->employee->addEducationHistory($a = new EmployeeEducationHistory());
        $this->employee->addEducationHistory($b = new EmployeeEducationHistory());
        self::assertCount(2, $this->employee->getEducationHistory());
        self::assertEquals($b, $this->employee->getNewestEducationHistory());
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\Employee
     * @group module
     */
    public function testSerialize() : void
    {
        $serialized = $this->employee->jsonSerialize();
        unset($serialized['profile']);

        self::assertEquals(
            [
                'id'            => 0,
                'history' => [],
                'workHistory' => [],
                'educationHistory' => [],
            ],
            $serialized
        );
    }
}
