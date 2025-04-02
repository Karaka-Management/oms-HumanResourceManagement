<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\tests\Models;

use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\NullEmployee;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\HumanResourceManagement\Models\EmployeeHistory::class)]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->history->id);
        self::assertNull($this->history->end);
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\Employee', $this->history->employee);
        self::assertInstanceOf('\Modules\Organization\Models\NullPosition', $this->history->position);
        self::assertInstanceOf('\Modules\Organization\Models\NullUnit', $this->history->unit);
        self::assertInstanceOf('\Modules\Organization\Models\NullDepartment', $this->history->department);
        self::assertInstanceOf('\DateTime', $this->history->start);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testSerialize() : void
    {
        $this->history->employee = new NullEmployee(2);

        $serialized = $this->history->jsonSerialize();
        unset($serialized['start']);
        unset($serialized['unit']);
        unset($serialized['department']);
        unset($serialized['position']);

        self::assertEquals(
            [
                'id'       => 0,
                'employee' => 2,
                'end'      => null,
            ],
            $serialized
        );
    }
}
