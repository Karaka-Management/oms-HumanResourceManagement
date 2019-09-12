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

use Modules\Organization\Models\Position;
use Modules\Organization\Models\NullPosition;
use Modules\Organization\Models\Unit;
use Modules\Organization\Models\NullUnit;
use Modules\Organization\Models\Department;
use Modules\Organization\Models\NullDepartment;

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
    private $id = 0;

    private $employee = null;

    private $unit = null;

    private $department = null;

    private $position = null;

    private $start = null;

    private $end = null;

    public function getId() : int
    {
        return $this->id;
    }

    public function getEmployee()
    {
        return $this->employee ?? new NullEmployee();
    }

    public function setEmployee($employee) : void
    {
        $this->employee = $employee;
    }

    public function getPosition() : Position
    {
        return $this->position ?? new NullPosition();
    }

    public function setPosition($position) : void
    {
        $this->position = $position;
    }

    public function getUnit() : Unit
    {
        return $this->unit ?? new NullUnit();
    }

    public function setUnit($unit) : void
    {
        $this->unit = $unit;
    }

    public function getDepartment() : Department
    {
        return $this->department ?? new NullDepartment();
    }

    public function setDepartment($department) : void
    {
        $this->department = $department;
    }

    public function getStart() : ?\DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start) : void
    {
        $this->start = $start;
    }

    public function getEnd() : ?\DateTime
    {
        return $this->end;
    }

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
            'id' => $this->id,
            'employee' => !\is_int($this->employee) ? $this->employee->getId() : $this->employee,
            'unit' => $this->unit,
            'department' => $this->department,
            'position' => $this->position,
            'start' => $this->start->format('Y-m-d H:i:s'),
            'end' => $this->end === null ? null : $this->end->format('Y-m-d H:i:s'),
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
