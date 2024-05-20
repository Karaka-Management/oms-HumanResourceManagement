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

use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeHistoryMapper;
use Modules\Profile\Models\ProfileMapper;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\HumanResourceManagement\Models\EmployeeHistoryMapper::class)]
final class EmployeeHistoryMapperTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testCRUD() : void
    {
        $employee = new Employee(ProfileMapper::get()->where('id', 1)->execute());

        $history = new EmployeeHistory($employee);

        $id = EmployeeHistoryMapper::create()->execute($history);
        self::assertGreaterThan(0, $history->id);
        self::assertEquals($id, $history->id);

        $historyR = EmployeeHistoryMapper::get()->where('id', $history->id)->execute();
        self::assertEquals($history->employee->id, $historyR->employee->id);
    }
}
