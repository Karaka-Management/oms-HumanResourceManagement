<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Controller;

use Modules\Admin\Models\Account;
use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeEducationHistory;
use Modules\HumanResourceManagement\Models\EmployeeEducationHistoryMapper;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeHistoryMapper;
use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\HumanResourceManagement\Models\EmployeeWorkHistory;
use Modules\HumanResourceManagement\Models\EmployeeWorkHistoryMapper;
use Modules\Profile\Models\Profile;
use Modules\Profile\Models\ProfileMapper;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;
use phpOMS\Stdlib\Base\AddressType;

/**
 * HumanResourceManagement controller class.
 *
 * @package Modules\HumanResourceManagement
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
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
     * @since 1.0.0
     */
    public function apiEmployeeCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if ($request->getData('profiles') !== null) {
            $this->apiEmployeeFromAccountCreate($request, $response, $data);

            return;
        }

        $this->apiEmployeeNewCreate($request, $response, $data);
    }

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
     * @since 1.0.0
     */
    public function apiEmployeeFromAccountCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeFromAccountCreate($request))) {
            $response->set('employee_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $employees = $this->createEmployeeFromAccountFromRequest($request);
        $this->createModels($request->header->account, $employees, EmployeeMapper::class, 'employee', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Employee', 'Employee(s) successfully created', $employees);
    }

    /**
     * Validate employee from profile create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmployeeFromAccountCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['profiles'] = empty($request->getData('profiles')))) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create employee from profile from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Employee[]
     *
     * @since 1.0.0
     */
    private function createEmployeeFromAccountFromRequest(RequestAbstract $request) : array
    {
        $accounts  = $request->getDataList('profiles') ?? [];
        $employees = [];

        foreach ($accounts as $account) {
            /** @var Profile $profile Profile */
            $profile     = ProfileMapper::getFor((int) $account, 'account');
            $employees[] = new Employee($profile);
        }

        return $employees;
    }

    /**
     * Api method to create a new employee
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeNewCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeNewCreate($request))) {
            $response->set('employee_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $employee = $this->createEmployeeNewFromRequest($request);
        $this->createModel($request->header->account, $employee, EmployeeMapper::class, 'employee', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Employee', 'Employee successfully created', $employee);
    }

    /**
     * Validate employee create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmployeeNewCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name1'] = empty($request->getData('name1')))) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create a new employee from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Employee
     *
     * @since 1.0.0
     */
    private function createEmployeeNewFromRequest(RequestAbstract $request) : Employee
    {
        $account        = new Account();
        $account->name1 = (string) ($request->getData('name1') ?? '');
        $account->name2 = (string) ($request->getData('name2') ?? '');
        $account->name3 = (string) ($request->getData('name3') ?? '');
        $account->name3 = (string) ($request->getData('email') ?? '');

        $profile           = new Profile($account);
        $profile->birthday = new \DateTime((string) ($request->getData('birthday') ?? 'now'));

        $employee = new Employee($profile);

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
     * @since 1.0.0
     */
    public function apiEmployeeHistoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeHistoryCreate($request))) {
            $response->set('history_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $history = $this->createEmployeeHistoryFromRequest($request);
        $this->createModel($request->header->account, $history, EmployeeHistoryMapper::class, 'history', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'History', 'History successfully created', $history);
    }

    /**
     * Validate employee history
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
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
     * @since 1.0.0
     */
    private function createEmployeeHistoryFromRequest(RequestAbstract $request) : EmployeeHistory
    {
        $history             = new EmployeeHistory((int) ($request->getData('employee') ?? 0));
        $history->unit       = (int) ($request->getData('unit') ?? 0);
        $history->department = (int) ($request->getData('department') ?? 0);
        $history->position   = (int) ($request->getData('position') ?? 0);
        $history->start      = new \DateTime($request->getData('start') ?? 'now');

        if (!empty($request->getData('end'))) {
            $history->end = new \DateTime($request->getData('end'));
        }

        return $history;
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
     * @since 1.0.0
     */
    public function apiEmployeeWorkHistoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeWorkHistoryCreate($request))) {
            $response->set('history_work_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $history = $this->createEmployeeWorkHistoryFromRequest($request);
        $this->createModel($request->header->account, $history, EmployeeWorkHistoryMapper::class, 'history', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'History', 'History successfully created', $history);
    }

    /**
     * Validate employee history
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmployeeWorkHistoryCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['employee'] = empty($request->getData('employee')))
            || ($val['start'] = empty($request->getData('start')))
            || ($val['title'] = empty($request->getData('title')))
            || ($val['name'] = empty($request->getData('name')))
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
     * @return EmployeeWorkHistory
     *
     * @since 1.0.0
     */
    private function createEmployeeWorkHistoryFromRequest(RequestAbstract $request) : EmployeeWorkHistory
    {
        $history                   = new EmployeeWorkHistory((int) ($request->getData('employee') ?? 0));
        $history->start            = new \DateTime($request->getData('start') ?? 'now');
        $history->jobTitle         = $request->getData('title');
        $history->address->name    = $request->getData('name');
        $history->address->address = $request->getData('address') ?? '';
        $history->address->postal  = $request->getData('postal') ?? '';
        $history->address->city    = $request->getData('city') ?? '';
        $history->address->state   = $request->getData('state') ?? '';
        $history->address->setCountry($request->getData('country') ?? '');
        $history->address->setType(AddressType::WORK);

        if (!empty($request->getData('end'))) {
            $history->end = new \DateTime($request->getData('end'));
        }

        return $history;
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
     * @since 1.0.0
     */
    public function apiEmployeeEducationHistoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeEducationHistoryCreate($request))) {
            $response->set('history_education_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $history = $this->createEmployeeEducationHistoryFromRequest($request);
        $this->createModel($request->header->account, $history, EmployeeEducationHistoryMapper::class, 'history', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'History', 'History successfully created', $history);
    }

    /**
     * Validate employee history
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmployeeEducationHistoryCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['employee'] = empty($request->getData('employee')))
            || ($val['start'] = empty($request->getData('start')))
            || ($val['title'] = empty($request->getData('title')))
            || ($val['name'] = empty($request->getData('name')))
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
     * @return EmployeeEducationHistory
     *
     * @since 1.0.0
     */
    private function createEmployeeEducationHistoryFromRequest(RequestAbstract $request) : EmployeeEducationHistory
    {
        $history                   = new EmployeeEducationHistory((int) ($request->getData('employee') ?? 0));
        $history->start            = new \DateTime($request->getData('start') ?? 'now');
        $history->educationTitle   = $request->getData('title');
        $history->score            = $request->getData('score') ?? '';
        $history->passed           = (bool) ($request->getData('passed') ?? true);
        $history->address->name    = $request->getData('name');
        $history->address->address = $request->getData('address') ?? '';
        $history->address->postal  = $request->getData('postal') ?? '';
        $history->address->city    = $request->getData('city') ?? '';
        $history->address->state   = $request->getData('state') ?? '';
        $history->address->setCountry($request->getData('country') ?? '');
        $history->address->setType(AddressType::EDUCATION);

        if (!empty($request->getData('end'))) {
            $history->end = new \DateTime($request->getData('end'));
        }

        return $history;
    }
}
