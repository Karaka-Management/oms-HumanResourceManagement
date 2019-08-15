<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package    Modules\HumanResourceManagement\Models
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use phpOMS\Contract\ArrayableInterface;

/**
 * Employee class.
 *
 * @package    Modules\HumanResourceManagement\Models
 * @license    OMS License 1.0
 * @link       https://orange-management.org
 * @since      1.0.0
 */
class Employee implements ArrayableInterface, \JsonSerializable
{

    /**
     * Employee ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    private $account = null;

    private $history = [];

    public function setAccount($account) : void
    {
        $this->account = $account;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getHistory() : array
    {
        return $this->history;
    }

    public function getNewestHistory() : EmployeeHistory
    {
        return empty($this->history) ? new NullEmployeeHistory : end($this->history);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id' => $this->id,
            'account' => $this->account,
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
