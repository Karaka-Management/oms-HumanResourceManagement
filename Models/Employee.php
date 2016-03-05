<?php
/**
 * Orange Management
 *
 * PHP Version 7.0
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Modules\HumanResources\Models;

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

    public function setAccount(Account $account) 
    {
        $this->account = $account;
    }

    public function getAccount() : Account {
        return $this->account;
    }
}
