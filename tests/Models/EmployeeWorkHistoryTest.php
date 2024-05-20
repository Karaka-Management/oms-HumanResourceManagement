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

use Modules\HumanResourceManagement\Models\EmployeeWorkHistory;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\HumanResourceManagement\Models\EmployeeWorkHistory::class)]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->history->id);
        self::assertNull($this->history->end);
        self::assertEquals(0, $this->history->employee);
        self::assertEquals('', $this->history->jobTitle);
        self::assertInstanceOf('\DateTime', $this->history->start);
        self::assertInstanceOf('\phpOMS\Stdlib\Base\Address', $this->history->address);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testSerialize() : void
    {
        $this->history->employee = 2;
        $this->history->jobTitle = 'title';

        $serialized = $this->history->jsonSerialize();
        unset($serialized['start']);

        self::assertEquals(
            [
                'id'       => 0,
                'employee' => 2,
                'jobTitle' => 'title',
                'end'      => null,
            ],
            $serialized
        );
    }
}
