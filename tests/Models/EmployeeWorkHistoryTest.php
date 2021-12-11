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

use Modules\HumanResourceManagement\Models\EmployeeWorkHistory;

/**
 * @internal
 */
final class EmployeeWorkHistoryTest extends \PHPUnit\Framework\TestCase
{
    private EmployeeWorkHistory $history;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->history = new EmployeeWorkHistory();
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeWorkHistory
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->history->getId());
        self::assertNull($this->history->end);
        self::assertEquals(0, $this->history->employee);
        self::assertEquals('', $this->history->jobTitle);
        self::assertInstanceOf('\DateTime', $this->history->start);
        self::assertInstanceOf('\Modules\Admin\Models\Address', $this->history->address);
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeWorkHistory
     * @group module
     */
    public function testSerialize() : void
    {
        $this->history->employee = 2;
        $this->history->jobTitle = 'title';

        $serialized = $this->history->jsonSerialize();
        unset($serialized['start']);

        self::assertEquals(
            [
                'id'         => 0,
                'employee'   => 2,
                'jobTitle'   => 'title',
                'end'        => null,
            ],
            $serialized
        );
    }
}