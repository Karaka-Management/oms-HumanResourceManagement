<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types=1);
namespace Modules\HumanResourceManagement\Models;

use Modules\Admin\Models\Account;

/**
 * Employee class.
 *
 * @category   HumanResources
 * @package    Framework
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Employee {

    /**
     * Employee ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    private $account = null;

    private $history = [];

    private $status = [];

    public function setAccount(Account $account) 
    {
        $this->account = $account;
    }

    public function getAccount() : Account {
        return $this->account;
    }

    public function getId() : int
    {
        return $this->id;
    }
}
