<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use phpOMS\Stdlib\Base\Address;

/**
 * Employee class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
class EmployeeWorkHistory implements \JsonSerializable
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    /**
     * Employee
     *
     * @var int|Employee
     * @since 1.0.0
     */
    public $employee = 0;

    public Address $address;

    public string $jobTitle = '';

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
        $this->employee = $employee;
        $this->start    = new \DateTime('now');
        $this->address  = new Address();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'       => $this->id,
            'employee' => \is_int($this->employee) ? $this->employee : $this->employee->id,
            'jobTitle' => $this->jobTitle,
            'start'    => $this->start,
            'end'      => $this->end,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }

    use \Modules\Media\Models\MediaListTrait;
}
