<?php
/**
 * Jingga
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
use Modules\HumanResourceManagement\Models\PermissionCategory;
use Modules\Media\Models\CollectionMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Media\Models\PathSettings;
use Modules\Organization\Models\NullDepartment;
use Modules\Organization\Models\NullPosition;
use Modules\Organization\Models\NullUnit;
use Modules\Profile\Models\Profile;
use Modules\Profile\Models\ProfileMapper;
use phpOMS\Account\PermissionType;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
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
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
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
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeFromAccountCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEmployeeFromAccountCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $employees = $this->createEmployeeFromAccountFromRequest($request);
        $this->createModels($request->header->account, $employees, EmployeeMapper::class, 'employee', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $employees);
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
            $profile  = ProfileMapper::get()->where('account', (int) $account)->execute();
            $employee = EmployeeMapper::get()->where('profile', $profile->id)->execute();

            $employees[] = $employee->id === 0 ? new Employee($profile) : $employee;
        }

        return $employees;
    }

    /**
     * Api method to create a new employee
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeNewCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEmployeeNewCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $employee = $this->createEmployeeNewFromRequest($request);
        $this->createModel($request->header->account, $employee, EmployeeMapper::class, 'employee', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $employee);
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
        $profile->birthday = new \DateTime($request->getDataString('birthday') ?? 'now');

        return new Employee($profile);
    }

    /**
     * Api method to create an employee history
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeHistoryCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEmployeeHistoryCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $history = $this->createEmployeeHistoryFromRequest($request);
        $this->createModel($request->header->account, $history, EmployeeHistoryMapper::class, 'history', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $history);
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
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeWorkHistoryCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEmployeeWorkHistoryCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $history = $this->createEmployeeWorkHistoryFromRequest($request);
        $this->createModel($request->header->account, $history, EmployeeWorkHistoryMapper::class, 'history', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $history);
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
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeEducationHistoryCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEmployeeEducationHistoryCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $history = $this->createEmployeeEducationHistoryFromRequest($request);
        $this->createModel($request->header->account, $history, EmployeeEducationHistoryMapper::class, 'history', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $history);
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
        $history->passed           = $request->getDataBool('passed') ?? true;
        $history->address->name    = $request->getDataString('name') ?? '';
        $history->address->address = $request->getDataString('address') ?? '';
        $history->address->postal  = $request->getDataString('postal') ?? '';
        $history->address->city    = $request->getDataString('city') ?? '';
        $history->address->state   = $request->getDataString('state') ?? '';
        $history->address->setCountry($request->getDataString('country') ?? '');
        $history->address->setType(AddressType::EDUCATION);

        return $history;
    }

    /**
     * Api method to create a bill
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiMediaAddToEmployee(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateMediaAddToEmployee($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidAddResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\HumanResourceManagement\Models\Employee $employee */
        $employee = EmployeeMapper::get()->where('id', (int) $request->getData('employee'))->execute();
        $path    = $this->createEmployeeDir($employee);

        $uploaded = [];
        if (!empty($uploadedFiles = $request->files)) {
            $uploaded = $this->app->moduleManager->get('Media')->uploadFiles(
                names: [],
                fileNames: [],
                files: $uploadedFiles,
                account: $request->header->account,
                basePath: __DIR__ . '/../../../Modules/Media/Files' . $path,
                virtualPath: $path,
                pathSettings: PathSettings::FILE_PATH,
                hasAccountRelation: false,
                readContent: $request->getDataBool('parse_content') ?? false
            );

            $collection = null;
            foreach ($uploaded as $media) {
                $this->createModelRelation(
                    $request->header->account,
                    $employee->id,
                    $media->id,
                    EmployeeMapper::class,
                    'files',
                    '',
                    $request->getOrigin()
                );

                if ($request->hasData('type')) {
                    $this->createModelRelation(
                        $request->header->account,
                        $media->id,
                        $request->getDataInt('type'),
                        MediaMapper::class,
                        'types',
                        '',
                        $request->getOrigin()
                    );
                }

                if ($collection === null) {
                    /** @var \Modules\Media\Models\Collection $collection */
                    $collection = MediaMapper::getParentCollection($path)->limit(1)->execute();

                    if ($collection->id === 0) {
                        $collection = $this->app->moduleManager->get('Media')->createRecursiveMediaCollection(
                            $path,
                            $request->header->account,
                            __DIR__ . '/../../../Modules/Media/Files' . $path,
                        );
                    }
                }

                $this->createModelRelation(
                    $request->header->account,
                    $collection->id,
                    $media->id,
                    CollectionMapper::class,
                    'sources',
                    '',
                    $request->getOrigin()
                );
            }
        }

        if (!empty($mediaFiles = $request->getDataJson('media'))) {
            foreach ($mediaFiles as $media) {
                $this->createModelRelation(
                    $request->header->account,
                    $employee->id,
                    (int) $media,
                    EmployeeMapper::class,
                    'files',
                    '',
                    $request->getOrigin()
                );
            }
        }

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Media', 'Media added to employee.', [
            'upload' => $uploaded,
            'media'  => $mediaFiles,
        ]);
    }

    /**
     * Create media directory path
     *
     * @param Employee $employee Employee
     *
     * @return string
     *
     * @since 1.0.0
     */
    private function createEmployeeDir(Employee $employee) : string
    {
        return '/Modules/HumanResourceManagement/Employee/'
            . $this->app->unitId . '/'
            . $employee->id;
    }

    /**
     * Method to validate bill creation from request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateMediaAddToEmployee(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['media'] = (!$request->hasData('media') && empty($request->files)))
            || ($val['employee'] = !$request->hasData('employee'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create notes
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiNoteCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateNoteCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $request->setData('virtualpath', '/Modules/HumanResourceManagement/Employee/' . $request->getData('id'), true);
        $this->app->moduleManager->get('Editor', 'Api')->apiEditorCreate($request, $response, $data);

        if ($response->header->status !== RequestStatusCode::R_200) {
            return;
        }

        $responseData = $response->getDataArray($request->uri->__toString());
        if (!\is_array($responseData)) {
            return;
        }

        $model = $responseData['response'];
        $this->createModelRelation($request->header->account, (int) $request->getData('id'), $model->id, EmployeeMapper::class, 'notes', '', $request->getOrigin());
    }

    /**
     * Validate item note create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateNoteCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update Note
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiNoteUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        $accountId = $request->header->account;
        if (!$this->app->accountManager->get($accountId)->hasPermission(
            PermissionType::MODIFY, $this->app->unitId, $this->app->appId, self::NAME, PermissionCategory::EMPLOYEE_NOTE, $request->getDataInt('id'))
        ) {
            $this->fillJsonResponse($request, $response, NotificationLevel::HIDDEN, '', '', []);
            $response->header->status = RequestStatusCode::R_403;

            return;
        }

        $this->app->moduleManager->get('Editor', 'Api')->apiEditorUpdate($request, $response, $data);
    }

    /**
     * Api method to delete Note
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiNoteDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        $accountId = $request->header->account;
        if (!$this->app->accountManager->get($accountId)->hasPermission(
            PermissionType::DELETE, $this->app->unitId, $this->app->appId, self::NAME, PermissionCategory::EMPLOYEE_NOTE, $request->getDataInt('id'))
        ) {
            $this->fillJsonResponse($request, $response, NotificationLevel::HIDDEN, '', '', []);
            $response->header->status = RequestStatusCode::R_403;

            return;
        }

        $this->app->moduleManager->get('Editor', 'Api')->apiEditorDelete($request, $response, $data);
    }
}
