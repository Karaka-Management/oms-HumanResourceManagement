<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use Modules\Media\Models\Media;
use Modules\Media\Models\NullMedia;
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
 * @license OMS License 2.0
 * @link    https://jingga.app
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
    public int $id = 0;

    /**
     * Employee
     *
     * @var Employee
     * @since 1.0.0
     */
    public Employee $employee;

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

    /** @todo Implement */
    public float $fte = 1.0;

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
    public function __construct()
    {
        $this->employee   = new NullEmployee();
        $this->start      = new \DateTime('now');
        $this->unit       = new NullUnit();
        $this->department = new NullDepartment();
        $this->position   = new NullPosition();
    }

    /**
     * Get media file by type
     *
     * @param int $type Media type
     *
     * @return Media
     *
     * @since 1.0.0
     */
    public function getFileByType(int $type) : Media
    {
        foreach ($this->files as $file) {
            if ($file->hasMediaTypeId($type)) {
                return $file;
            }
        }

        return new NullMedia();
    }

    /**
     * Get all media files by type name
     *
     * @param string $type Media type
     *
     * @return Media
     *
     * @since 1.0.0
     */
    public function getFileByTypeName(string $type) : Media
    {
        foreach ($this->files as $file) {
            if ($file->hasMediaTypeName($type)) {
                return $file;
            }
        }

        return new NullMedia();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'         => $this->id,
            'employee'   => \is_int($this->employee) ? $this->employee : $this->employee->id,
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

    use \Modules\Media\Models\MediaListTrait;
}
