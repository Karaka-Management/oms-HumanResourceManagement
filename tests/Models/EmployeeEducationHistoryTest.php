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

use Modules\HumanResourceManagement\Models\EmployeeEducationHistory;

/**
 * @internal
 */
final class EmployeeEducationHistoryTest extends \PHPUnit\Framework\TestCase
{
    private EmployeeEducationHistory $history;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->history = new EmployeeEducationHistory();
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeEducationHistory
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->history->getId());
        self::assertNull($this->history->end);
        self::assertEquals(0, $this->history->employee);
        self::assertEquals('', $this->history->educationTitle);
        self::assertTrue($this->history->passed);
        self::assertEquals('', $this->history->score);
        self::assertInstanceOf('\DateTime', $this->history->start);
        self::assertInstanceOf('\Modules\Admin\Models\Address', $this->history->address);
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeEducationHistory
     * @group module
     */
    public function testSerialize() : void
    {
        $this->history->employee       = 2;
        $this->history->educationTitle = 'title';
        $this->history->score          = '69';
        $this->history->passed         = false;

        $serialized = $this->history->jsonSerialize();
        unset($serialized['start']);

        self::assertEquals(
            [
                'id'               => 0,
                'employee'         => 2,
                'educationTitle'   => 'title',
                'passed'           => false,
                'score'            => '69',
                'end'              => null,
            ],
            $serialized
        );
    }
}