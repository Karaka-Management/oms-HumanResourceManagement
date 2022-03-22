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

use Modules\Media\Models\Media;
use Modules\Media\Models\NullMedia;
use Modules\Profile\Models\NullProfile;
use Modules\Profile\Models\Profile;
use phpOMS\Contract\ArrayableInterface;

/**
 * Employee class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
class Employee implements \JsonSerializable, ArrayableInterface
{
    /**
     * Employee ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Account profile.
     *
     * @var Profile
     * @since 1.0.0
     */
    public Profile $profile;

    /**
     * Employee image.
     *
     * @var null|int|Media
     * @since 1.0.0
     */
    public $image = null;

    /**
     * Files.
     *
     * @var Media[]
     * @since 1.0.0
     */
    private array $files = [];

    /**
     * Employee department/position history.
     *
     * @var array
     * @since 1.0.0
     */
    private array $companyHistory = [];

    /**
     * Employee education history.
     *
     * @var array
     * @since 1.0.0
     */
    private array $educationHistory = [];

    /**
     * Employee external work history.
     *
     * @var array
     * @since 1.0.0
     */
    private array $workHistory = [];

    /**
     * Employee hash used for time tracking / employee card
     *
     * @var string
     * @since 1.0.0
     */
    private string $semiPrivateHash = '';

    /**
     * Employee hash length used for time tracking / employee card
     *
     * @var int
     * @since 1.0.0
     */
    private const SEMI_PRIVATE_HASH_LENGTH = 64;

    /**
     * Constructor.
     *
     * @param Profile $profile Account profile to initialize this employee with
     *
     * @since 1.0.0
     */
    public function __construct(Profile $profile = null)
    {
        $this->profile         = $profile ?? new NullProfile();
        $this->semiPrivateHash = \random_bytes(self::SEMI_PRIVATE_HASH_LENGTH);
        $this->image           = new NullMedia();
    }

    /**
     * Get id.
     *
     * @return int Employee id
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
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
     * Add company history to employee
     *
     * @param mixed $history Company history
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addHistory($history) : void
    {
        $this->companyHistory[] = $history;
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
        return empty($this->companyHistory) ? new NullEmployeeHistory() : \end($this->companyHistory);
    }

    /**
     * Add company history to employee
     *
     * @param mixed $history Company history
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addEducationHistory($history) : void
    {
        $this->educationHistory[] = $history;
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
        return empty($this->educationHistory) ? new NullEmployeeEducationHistory() : \end($this->educationHistory);
    }

    /**
     * Add company history to employee
     *
     * @param mixed $history Company history
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addWorkHistory($history) : void
    {
        $this->workHistory[] = $history;
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
        return empty($this->workHistory) ? new NullEmployeeWorkHistory() : \end($this->workHistory);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'               => $this->id,
            'profile'          => $this->profile,
            'history'          => $this->companyHistory,
            'workHistory'      => $this->workHistory,
            'educationHistory' => $this->educationHistory,
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
