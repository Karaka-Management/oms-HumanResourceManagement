<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use Modules\Organization\Models\Department;
use Modules\Organization\Models\NullDepartment;
use Modules\Organization\Models\NullPosition;
use Modules\Organization\Models\NullUnit;
use Modules\Organization\Models\Position;
use Modules\Organization\Models\Unit;

use phpOMS\Contract\ArrayableInterface;

/**
 * Employee class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class EmployeeHistory implements ArrayableInterface, \JsonSerializable
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
    private $employee = 0;

    /**
     * Unit
     *
     * @var null|int|Unit
     * @since 1.0.0
     */
    private $unit = null;

    /**
     * Department
     *
     * @var null|int|Department
     * @since 1.0.0
     */
    private $department = null;

    /**
     * Position
     *
     * @var null|int|Position
     * @since 1.0.0
     */
    private $position = null;

    /**
     * Start date
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private \DateTime $start;

    /**
     * End date
     *
     * @var null|\DateTime
     * @since 1.0.0
     */
    private ?\DateTime $end = null;

    /**
     * Constructor.
     *
     * @param int|Employee $employee Employee
     *
     * @since 1.0.0
     */
    public function __construct($employee = 0)
    {
        $this->employee = $employee;
        $this->start    = new \DateTime('now');
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
     * Get the employee this history belongs to
     *
     * @return int|Employee
     *
     * @since 1.0.0
     */
    public function getEmployee()
    {
        return empty($this->employee) ? new NullEmployee() : $this->employee;
    }

    /**
     * Get the position
     *
     * @return int|Position
     *
     * @since 1.0.0
     */
    public function getPosition()
    {
        return empty($this->position) ? new NullPosition() : $this->position;
    }

    /**
     * Set the position
     *
     * @param int|Position $position Position
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setPosition($position) : void
    {
        $this->position = $position;
    }

    /**
     * Get the unit
     *
     * @return int|Unit
     *
     * @since 1.0.0
     */
    public function getUnit()
    {
        return empty($this->unit) ? new NullUnit() : $this->unit;
    }

    /**
     * Set the unit
     *
     * @param int|Unit $unit Unit
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setUnit($unit) : void
    {
        $this->unit = $unit;
    }

    /**
     * Get the department
     *
     * @return int|Department
     *
     * @since 1.0.0
     */
    public function getDepartment()
    {
        return empty($this->department) ? new NullDepartment() : $this->department;
    }

    /**
     * Set the department
     *
     * @param int|Department $department Department
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setDepartment($department) : void
    {
        $this->department = $department;
    }

    /**
     * Get start date
     *
     * @return \DateTime
     *
     * @since 1.0.0
     */
    public function getStart() : \DateTime
    {
        return $this->start;
    }

    /**
     * Set start date
     *
     * @param \DateTime $start Start date
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setStart(\DateTime $start) : void
    {
        $this->start = $start;
    }

    /**
     * Get end date
     *
     * @return null|\DateTime
     *
     * @since 1.0.0
     */
    public function getEnd() : ?\DateTime
    {
        return $this->end;
    }

    /**
     * Set end date
     *
     * @param \DateTime $end End date
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setEnd(\DateTime $end) : void
    {
        $this->end = $end;
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
    public function __toString()
    {
        return (string) \json_encode($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
