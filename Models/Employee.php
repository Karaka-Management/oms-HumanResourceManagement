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
class Employee implements ArrayableInterface, \JsonSerializable
{

    /**
     * Employee ID.
     *
     * @var   int
     * @since 1.0.0
     */
    private int $id = 0;

    /**
     * Account profile.
     *
     * @var   null|int|Profile
     * @since 1.0.0
     */
    private $profile = null;

    /**
     * Employee department/position history.
     *
     * @var   array
     * @since 1.0.0
     */
    private array $companyHistory = [];

    /**
     * Employee education history.
     *
     * @todo: implement!
     *
     * @var   array
     * @since 1.0.0
     */
    private array $educationHistory = [];

    /**
     * Employee external work history.
     *
     * @var   array
     * @since 1.0.0
     */
    private array $workHistory = [];

    /**
     * Employee hash used for time tracking / employee card
     *
     * @var   string
     * @since 1.0.0
     */
    private string $semiPrivateHash = '';

    /**
     * Employee hash length used for time tracking / employee card
     *
     * @var   int
     * @since 1.0.0
     */
    private const SEMI_PRIVATE_HASH_LENGTH = 64;

    /**
     * Constructor.
     *
     * @param null|Profile $profile Account profile to initialize this employee with
     *
     * @since 1.0.0
     */
    public function __construct($profile = null)
    {
        $this->profile         = $profile;
        $this->semiPrivateHash = \random_bytes(self::SEMI_PRIVATE_HASH_LENGTH);
    }

    /**
     * Get account id.
     *
     * @return int Account id
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get profile.
     *
     * @return null|int|Profile
     *
     * @since 1.0.0
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Update semi private hash.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function updateSemiPrivateHash() : void
    {
        $this->semiPrivateHash = \random_bytes(self::SEMI_PRIVATE_HASH_LENGTH);
    }

    /**
     * Get semi private hash.
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getSemiPrivateHash() : string
    {
        return $this->semiPrivateHash;
    }

    /**
     * Compare two hashs
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public function compareSemiPrivateHash(string $hash) : bool
    {
        return \hash_equals($this->semiPrivateHash, $hash);
    }

    /**
     * Get employee company history.
     *
     * @return array Employee history
     *
     * @since 1.0.0
     */
    public function getHistory() : array
    {
        return $this->companyHistory;
    }

    /**
     * Get newest company history.
     *
     * @return EmployeeHistory
     *
     * @since 1.0.0
     */
    public function getNewestHistory() : EmployeeHistory
    {
        return empty($this->companyHistory) ? new NullEmployeeHistory : end($this->companyHistory);
    }

    /**
     * Get employee company education history.
     *
     * @return array Employee education history
     *
     * @since 1.0.0
     */
    public function getEducationHistory() : array
    {
        return $this->educationHistory;
    }

    /**
     * Get newest company education history.
     *
     * @return EmployeeEducationHistory
     *
     * @since 1.0.0
     */
    public function getNewestEducationHistory() : EmployeeEducationHistory
    {
        return empty($this->educationHistory) ? new NullEmployeeEducationHistory : end($this->educationHistory);
    }

    /**
     * Get employee company work.
     *
     * @return array Employee work
     *
     * @since 1.0.0
     */
    public function getWorkHistory() : array
    {
        return $this->workHistory;
    }

    /**
     * Get newest company work.
     *
     * @return EmployeeWorkHistory
     *
     * @since 1.0.0
     */
    public function getNewestWorkHistory() : EmployeeWorkHistory
    {
        return empty($this->workHistory) ? new NullEmployeeWorkHistory : end($this->workHistory);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'      => $this->id,
            'profile' => $this->profile,
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
