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

use Modules\HumanResourceManagement\Models\EmployeeHistory;

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
        self::assertEquals(0, $this->history->employee);
        self::assertInstanceOf('\Modules\Organization\Models\NullPosition', $this->history->position);
        self::assertInstanceOf('\Modules\Organization\Models\NullUnit', $this->history->unit);
        self::assertInstanceOf('\Modules\Organization\Models\NullDepartment', $this->history->department);
        self::assertInstanceOf('\DateTime', $this->history->start);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testSerialize() : void
    {
        $this->history->employee = 2;

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
