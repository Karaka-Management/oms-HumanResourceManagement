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

use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeHistoryMapper;
use Modules\Profile\Models\ProfileMapper;

/**
 * @internal
 */
class EmployeeHistoryMapperTest extends \PHPUnit\Framework\TestCase
{
    public function testCRUD() : void
    {
        $employee = new Employee(ProfileMapper::get(1));

        $history = new EmployeeHistory($employee);

        $id = EmployeeHistoryMapper::create($history);
        self::assertGreaterThan(0, $history->getId());
        self::assertEquals($id, $history->getId());

        $historyR = EmployeeHistoryMapper::get($history->getId());
        self::assertEquals($history->getEmployee()->getId(), $historyR->getEmployee()->getId());
    }
}
