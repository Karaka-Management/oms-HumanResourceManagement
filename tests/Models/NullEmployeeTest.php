<?php
/**
 * Karaka
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
