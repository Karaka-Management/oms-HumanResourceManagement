<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use Modules\Admin\Models\Address;
use Modules\Media\Models\Media;
use phpOMS\Contract\ArrayableInterface;

/**
 * Employee class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
class EmployeeEducationHistory implements \JsonSerializable, ArrayableInterface
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

    public Address $address;

    public string $educationTitle = '';

    public bool $passed = true;

    public string $score = '';

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
        $this->employee = $employee;
        $this->start    = new \DateTime('now');
        $this->address  = new Address();
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
            'id'                    => $this->id,
            'employee'              => !\is_int($this->employee) ? $this->employee->getId() : $this->employee,
            'educationTitle'        => $this->educationTitle,
            'passed'                => $this->passed,
            'score'                 => $this->score,
            'start'                 => $this->start,
            'end'                   => $this->end,
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
