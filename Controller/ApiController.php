<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package    Modules\HumanResourceManagement
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Controller;

use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeHistoryMapper;

use phpOMS\Account\Account;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;
use phpOMS\Utils\Parser\Markdown\Markdown;

/**
 * HumanResourceManagement controller class.
 *
 * @package    Modules\HumanResourceManagement
 * @license    OMS License 1.0
 * @link       https://orange-management.org
 * @since      1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Api method to create an employee from an existing account
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since  1.0.0
     */
    public function apiEmployeeFromAccountCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeFromAccountCreate($request))) {
            $response->set('employee_create', new FormValidation($val));

            return;
        }

        $employee = $this->createEmployeeFromAccountFromRequest($request);
        $this->createModel($request->getHeader()->getAccount(), $employee, EmployeeMapper::class, 'employee');
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Employee', 'Employee successfully created', $employee);
    }

    /**
     * Validate employee from account create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since  1.0.0
     */
    private function validateEmployeeFromAccountCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['account'] = empty($request->getData('account')))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create employee from account from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Employee
     *
     * @since  1.0.0
     */
    private function createEmployeeFromAccountFromRequest(RequestAbstract $request) : Employee
    {
        $employee = new Employee();
        $employee->setAccount((int) ($request->getData('account') ?? 0));

        return $employee;
    }

    /**
     * Api method to create an employee history
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since  1.0.0
     */
    public function apiEmployeeHistoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeHistoryCreate($request))) {
            $response->set('history_create', new FormValidation($val));

            return;
        }

        $history = $this->createEmployeeHistoryFromRequest($request);
        $this->createModel($request->getHeader()->getAccount(), $history, EmployeeHistoryMapper::class, 'history');
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'History', 'History successfully created', $history);
    }

    /**
     * Validate employee history
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since  1.0.0
     */
    private function validateEmployeeHistoryCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['employee'] = empty($request->getData('employee')))
            || ($val['start'] = empty($request->getData('start')))
            || ($val['unit'] = empty($request->getData('unit')))
            || ($val['department'] = empty($request->getData('department')))
            || ($val['position'] = empty($request->getData('position')))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create employee history from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return EmployeeHistory
     *
     * @since  1.0.0
     */
    private function createEmployeeHistoryFromRequest(RequestAbstract $request) : EmployeeHistory
    {
        $history = new EmployeeHistory();
        $history->setEmployee((int) ($request->getData('employee') ?? 0));
        $history->setUnit((int) ($request->getData('unit') ?? 0));
        $history->setDepartment((int) ($request->getData('department') ?? 0));
        $history->setPosition((int) ($request->getData('position') ?? 0));
        $history->setStart(new \DateTime($request->getData('start') ?? 'now'));

        if (!empty($request->getData('end'))) {
            $history->setEnd(new \DateTime($request->getData('end')));
        }

        return $history;
    }
}
