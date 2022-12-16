<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\tests\Models;

use Modules\HumanResourceManagement\Models\NullEmployeeEducationHistory;

/**
 * @internal
 */
final class NullEmployeeEducationHistoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\HumanResourceManagement\Models\NullEmployeeEducationHistory
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\EmployeeEducationHistory', new NullEmployeeEducationHistory());
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\NullEmployeeEducationHistory
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullEmployeeEducationHistory(2);
        self::assertEquals(2, $null->getId());
    }
}
