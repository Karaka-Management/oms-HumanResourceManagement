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

use Modules\HumanResourceManagement\Models\EmployeeHistory;

/**
 * @internal
 */
final class EmployeeHistoryTest extends \PHPUnit\Framework\TestCase
{
    private EmployeeHistory $history;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->history = new EmployeeHistory();
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeHistory
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->history->getId());
        self::assertNull($this->history->end);
        self::assertEquals(0, $this->history->employee);
        self::assertNull($this->history->position);
        self::assertNull($this->history->unit);
        self::assertNull($this->history->department);
        self::assertInstanceOf('\DateTime', $this->history->start);
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeHistory
     * @group module
     */
    public function testSerialize() : void
    {
        $this->history->employee = 2;

        $serialized = $this->history->jsonSerialize();
        unset($serialized['start']);

        self::assertEquals(
            [
                'id'         => 0,
                'employee'   => 2,
                'unit'       => null,
                'department' => null,
                'position'   => null,
                'end'        => null,
            ],
            $serialized
        );
    }
}
