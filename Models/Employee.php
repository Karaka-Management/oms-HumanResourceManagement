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
class Employee extends Account {

    /**
     * Employee ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $employeeId = 0;

    public function getInstance($id)
    {
        if (!isset(self::$instances[$id])) {
            self::$instances[$id] = new self($id);
        }

        return self::$instances[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function init($id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
    }

    public function setUser($id)
    {
        $this->user = new User($id);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        // TODO: Implement create() method.
    }

    /**
     * {@inheritdoc}
     */
    public function update()
    {
        // TODO: Implement update() method.
    }
}
