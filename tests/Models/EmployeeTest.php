<?php
/**
 * Jingga
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

use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeEducationHistory;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeWorkHistory;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\HumanResourceManagement\Models\Employee::class)]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->employee->id);
        self::assertGreaterThan(0, \strlen($this->employee->getSemiPrivateHash()));
        self::assertFalse($this->employee->compareSemiPrivateHash('123'));
        self::assertInstanceOf('\Modules\Media\Models\NullMedia', $this->employee->image);
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\NullEmployeeHistory', $this->employee->getNewestHistory());
        self::assertEquals([], $this->employee->getHistory());
        self::assertEquals([], $this->employee->getEducationHistory());
        self::assertEquals([], $this->employee->getWorkHistory());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testPrivateHashInputOutput() : void
    {
        $temp = $this->employee->getSemiPrivateHash();
        self::assertTrue($this->employee->compareSemiPrivateHash($temp));
        $this->employee->updateSemiPrivateHash();
        self::assertFalse($this->employee->compareSemiPrivateHash($temp));
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testHistoryInputOutput() : void
    {
        $this->employee->addHistory($a = new EmployeeHistory());
        $this->employee->addHistory($b = new EmployeeHistory());
        self::assertCount(2, $this->employee->getHistory());
        self::assertEquals($b, $this->employee->getNewestHistory());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testWorkHistoryInputOutput() : void
    {
        $this->employee->addWorkHistory($a = new EmployeeWorkHistory());
        $this->employee->addWorkHistory($b = new EmployeeWorkHistory());
        self::assertCount(2, $this->employee->getWorkHistory());
        self::assertEquals($b, $this->employee->getNewestWorkHistory());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testEducationHistoryInputOutput() : void
    {
        $this->employee->addEducationHistory($a = new EmployeeEducationHistory());
        $this->employee->addEducationHistory($b = new EmployeeEducationHistory());
        self::assertCount(2, $this->employee->getEducationHistory());
        self::assertEquals($b, $this->employee->getNewestEducationHistory());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testSerialize() : void
    {
        $serialized = $this->employee->jsonSerialize();
        unset($serialized['profile']);

        self::assertEquals(
            [
                'id'               => 0,
                'history'          => [],
                'workHistory'      => [],
                'educationHistory' => [],
            ],
            $serialized
        );
    }
}
