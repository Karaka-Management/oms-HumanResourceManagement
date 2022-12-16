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

use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeHistoryMapper;
use Modules\Profile\Models\ProfileMapper;

/**
 * @internal
 */
final class EmployeeHistoryMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeHistoryMapper
     * @group module
     */
    public function testCRUD() : void
    {
        $employee = new Employee(ProfileMapper::get()->where('id', 1)->execute());

        $history = new EmployeeHistory($employee);

        $id = EmployeeHistoryMapper::create()->execute($history);
        self::assertGreaterThan(0, $history->getId());
        self::assertEquals($id, $history->getId());

        $historyR = EmployeeHistoryMapper::get()->where('id', $history->getId())->execute();
        self::assertEquals($history->employee->getId(), $historyR->employee->getId());
    }
}
