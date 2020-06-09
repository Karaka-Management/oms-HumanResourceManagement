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

use phpOMS\Contract\ArrayableInterface;

/**
 * Employee class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class EmployeeWorkHistory implements ArrayableInterface, \JsonSerializable
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
