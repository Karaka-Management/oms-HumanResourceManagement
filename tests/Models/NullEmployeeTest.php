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

use Modules\HumanResourceManagement\Models\NullEmployee;

/**
 * @internal
 */
final class NullEmployeeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\HumanResourceManagement\Models\NullEmployee
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\Employee', new NullEmployee());
    }

    /**
     * @covers Modules\HumanResourceManagement\Models\NullEmployee
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullEmployee(2);
        self::assertEquals(2, $null->getId());
    }
}