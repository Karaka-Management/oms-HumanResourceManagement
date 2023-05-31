<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
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
use Modules\Organization\Models\NullDepartment;
use Modules\Organization\Models\NullPosition;
use Modules\Organization\Models\NullUnit;
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
 * @license OMS License 2.0
 * @link    https://jingga.app
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
    public function apiEmployeeCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if ($request->hasData('profiles')) {
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
    public function apiEmployeeFromAccountCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeFromAccountCreate($request))) {
            $response->data['employee_create'] = new FormValidation($val);
            $response->header->status          = RequestStatusCode::R_400;

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
        if (($val['profiles'] = !$request->hasData('profiles'))) {
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
        $accounts  = $request->getDataList('profiles');
        $employees = [];

        foreach ($accounts as $account) {
            /** @var Profile $profile Profile */
            $profile     = ProfileMapper::get()->where('account', (int) $account)->execute();
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
    public function apiEmployeeNewCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeNewCreate($request))) {
            $response->data['employee_create'] = new FormValidation($val);
            $response->header->status          = RequestStatusCode::R_400;

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
        if (($val['name1'] = !$request->hasData('name1'))) {
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
        $account->name1 = $request->getDataString('name1') ?? '';
        $account->name2 = $request->getDataString('name2') ?? '';
        $account->name3 = $request->getDataString('name3') ?? '';
        $account->name3 = $request->getDataString('email') ?? '';

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
    public function apiEmployeeHistoryCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeHistoryCreate($request))) {
            $response->data['history_create'] = new FormValidation($val);
            $response->header->status         = RequestStatusCode::R_400;

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
        if (($val['employee'] = !$request->hasData('employee'))
            || ($val['start'] = !$request->hasData('start'))
            || ($val['unit'] = !$request->hasData('unit'))
            || ($val['department'] = !$request->hasData('department'))
            || ($val['position'] = !$request->hasData('position'))
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
        $history             = new EmployeeHistory($request->getDataInt('employee') ?? 0);
        $history->unit       = new NullUnit($request->getDataInt('unit') ?? 0);
        $history->department = new NullDepartment($request->getDataInt('department') ?? 0);
        $history->position   = new NullPosition($request->getDataInt('position') ?? 0);
        $history->start      = $request->getDataDateTime('start') ?? new \DateTime('now');
        $history->end        = $request->getDataDateTime('end');

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
    public function apiEmployeeWorkHistoryCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeWorkHistoryCreate($request))) {
            $response->data['history_work_create'] = new FormValidation($val);
            $response->header->status              = RequestStatusCode::R_400;

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
        if (($val['employee'] = !$request->hasData('employee'))
            || ($val['start'] = !$request->hasData('start'))
            || ($val['title'] = !$request->hasData('title'))
            || ($val['name'] = !$request->hasData('name'))
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
        $history                   = new EmployeeWorkHistory($request->getDataInt('employee') ?? 0);
        $history->start            = $request->getDataDateTime('start') ?? new \DateTime('now');
        $history->end              = $request->getDataDateTime('end');
        $history->jobTitle         = $request->getDataString('title') ?? '';
        $history->address->name    = $request->getDataString('name') ?? '';
        $history->address->address = $request->getDataString('address') ?? '';
        $history->address->postal  = $request->getDataString('postal') ?? '';
        $history->address->city    = $request->getDataString('city') ?? '';
        $history->address->state   = $request->getDataString('state') ?? '';
        $history->address->setCountry($request->getDataString('country') ?? '');
        $history->address->setType(AddressType::WORK);

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
    public function apiEmployeeEducationHistoryCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeEducationHistoryCreate($request))) {
            $response->data['history_education_create'] = new FormValidation($val);
            $response->header->status                   = RequestStatusCode::R_400;

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
        if (($val['employee'] = !$request->hasData('employee'))
            || ($val['start'] = !$request->hasData('start'))
            || ($val['title'] = !$request->hasData('title'))
            || ($val['name'] = !$request->hasData('name'))
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
        $history                   = new EmployeeEducationHistory($request->getDataInt('employee') ?? 0);
        $history->start            = $request->getDataDateTime('start') ?? new \DateTime('now');
        $history->end              = $request->getDataDateTime('end');
        $history->educationTitle   = $request->getDataString('title') ?? '';
        $history->score            = $request->getDataString('score') ?? '';
        $history->passed           = (bool) ($request->getData('passed') ?? true);
        $history->address->name    = $request->getDataString('name') ?? '';
        $history->address->address = $request->getDataString('address') ?? '';
        $history->address->postal  = $request->getDataString('postal') ?? '';
        $history->address->city    = $request->getDataString('city') ?? '';
        $history->address->state   = $request->getDataString('state') ?? '';
        $history->address->setCountry($request->getDataString('country') ?? '');
        $history->address->setType(AddressType::EDUCATION);

        return $history;
    }
}
