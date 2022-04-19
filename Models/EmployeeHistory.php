<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use Modules\Media\Models\Media;
use Modules\Organization\Models\Department;
use Modules\Organization\Models\NullDepartment;
use Modules\Organization\Models\NullPosition;
use Modules\Organization\Models\NullUnit;
use Modules\Organization\Models\Position;
use Modules\Organization\Models\Unit;

/**
 * Employee class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
class EmployeeHistory implements \JsonSerializable
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Employee
     *
     * @var int|Employee
     * @since 1.0.0
     */
    public $employee = 0;

    /**
     * Unit
     *
     * @var Unit
     * @since 1.0.0
     */
    public Unit $unit;

    /**
     * Department
     *
     * @var Department
     * @since 1.0.0
     */
    public Department $department;

    /**
     * Position
     *
     * @var Position
     * @since 1.0.0
     */
    public Position $position;

    /**
     * Files.
     *
     * @var Media[]
     * @since 1.0.0
     */
    private array $files = [];

    /**
     * Start date
     *
     * @var \DateTime
     * @since 1.0.0
     */
    public \DateTime $start;

    /**
     * End date
     *
     * @var null|\DateTime
     * @since 1.0.0
     */
    public ?\DateTime $end = null;

    /**
     * Constructor.
     *
     * @param int|Employee $employee Employee
     *
     * @since 1.0.0
     */
    public function __construct($employee = 0)
    {
        $this->employee   = $employee;
        $this->start      = new \DateTime('now');
        $this->unit       = new NullUnit();
        $this->department = new NullDepartment();
        $this->position   = new NullPosition();
    }

    /**
     * Get id.
     *
     * @return int Model id
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'         => $this->id,
            'employee'   => !\is_int($this->employee) ? $this->employee->getId() : $this->employee,
            'unit'       => $this->unit,
            'department' => $this->department,
            'position'   => $this->position,
            'start'      => $this->start,
            'end'        => $this->end,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }
}
