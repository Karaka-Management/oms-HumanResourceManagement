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

use Modules\HumanResourceManagement\Models\NullEmployeeEducationHistory;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\HumanResourceManagement\Models\NullEmployeeEducationHistory::class)]
final class NullEmployeeEducationHistoryTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\HumanResourceManagement\Models\EmployeeEducationHistory', new NullEmployeeEducationHistory());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testId() : void
    {
        $null = new NullEmployeeEducationHistory(2);
        self::assertEquals(2, $null->id);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testJsonSerialize() : void
    {
        $null = new NullEmployeeEducationHistory(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
