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

use Modules\HumanResourceManagement\Models\EmployeeHistory;

/**
 * @internal
 */
class EmployeeHistoryTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault() : void
    {
        $history = new EmployeeHistory();

        self::assertEquals(0, $history->getId());
        self::assertNull($history->getEnd());
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\NullEmployee', $history->getEmployee());
        self::assertInstanceOf('\Modules\Organization\Models\NullPosition', $history->getPosition());
        self::assertInstanceOf('\Modules\Organization\Models\NullUnit', $history->getUnit());
        self::assertInstanceOf('\Modules\Organization\Models\NullDepartment', $history->getDepartment());
        self::assertInstanceOf('\DateTime', $history->getStart());
    }
}
