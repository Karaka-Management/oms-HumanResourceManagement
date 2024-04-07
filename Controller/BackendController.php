<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Controller;

use Modules\HumanResourceManagement\Models\EmployeeHistoryMapper;
use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\HumanResourceTimeRecording\Models\SessionMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Organization\Models\Department;
use Modules\Organization\Models\DepartmentMapper;
use Modules\Organization\Models\Position;
use Modules\Organization\Models\PositionMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Profile\Models\SettingsEnum;
use phpOMS\Contract\RenderableInterface;
use phpOMS\DataStorage\Database\Query\OrderType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Stdlib\Base\SmartDateTime;
use phpOMS\Views\View;

/**
 * Human Resources controller class.
 *
 * @package Modules\HumanResourceManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

        $view->data['employees'] = EmployeeMapper::getAll()
            ->with('profile')
            ->with('profile/account')
            ->with('image')
            ->with('profile/image')
            ->with('companyHistory')
            ->with('companyHistory/unit')
            ->with('companyHistory/department')
            ->with('companyHistory/position')
            ->sort('companyHistory/start', OrderType::DESC)
            //->limit(1, 'companyHistory') // @todo This is not working since it returns 1 for ALL employees instead of per employee
            ->executeGetArray();

        /** @var \Model\Setting $profileImage */
        $profileImage = $this->app->appSettings->get(names: SettingsEnum::DEFAULT_PROFILE_IMAGE, module: 'Profile');

        /** @var \Modules\Media\Models\Media $image */
        $image = MediaMapper::get()
            ->where('id', (int) $profileImage->content)
            ->execute();

        $view->data['defaultImage'] = $image;

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-create');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

        $accSelector               = new \Modules\Profile\Theme\Backend\Components\AccountGroupSelector\BaseView($this->app->l11nManager, $request, $response);
        $view->data['accSelector'] = $accSelector;

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffView(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

         $view->data['employee'] = EmployeeMapper::get()
            ->with('profile')
            ->with('profile/account')
            ->with('profile/account/address')
            ->with('profile/account/contacts')
            ->with('image')
            ->with('notes')
            ->with('files')
            ->with('profile/image')
            ->with('companyHistory')
            ->with('companyHistory/unit')
            ->with('companyHistory/department')
            ->with('companyHistory/position')
            ->with('educationHistory')
            ->with('workHistory')
            ->where('id', (int) $request->getData('id'))
            ->sort('companyHistory/start', OrderType::DESC)
            ->sort('educationHistory/start', OrderType::DESC)
            ->sort('workHistory/start', OrderType::DESC)
            ->execute();

        $view->data['units']       = UnitMapper::getAll()->executeGetArray();
        $view->data['departments'] = DepartmentMapper::getAll()->executeGetArray();
        $view->data['positions']   = PositionMapper::getAll()->executeGetArray();

        $view->data['media-upload']   = new \Modules\Media\Theme\Backend\Components\Upload\BaseView($this->app->l11nManager, $request, $response);
        $view->data['employee-notes'] = new \Modules\Editor\Theme\Backend\Components\Compound\BaseView($this->app->l11nManager, $request, $response);

        if ($this->app->moduleManager->isActive('HumanResourceTimeRecording')) {
            /** @var \Modules\HumanResourceTimeRecording\Models\Session $lastOpenSession */
            $lastOpenSession = SessionMapper::getMostPlausibleOpenSessionForEmployee($view->data['employee']->id);

            $start = new SmartDateTime('now');
            $start = $start->getEndOfDay();
            $limit = $start->getEndOfMonth();
            $limit->smartModify(0, -2, 0);

            $list = SessionMapper::getAll()
                ->with('sessionElements')
                ->where('employee',  $view->data['employee']->id)
                ->where('start', $start, '<=')
                ->sort('start', OrderType::DESC)
                ->executeGetArray();

            $view->data['sessions']    = $list;
            $view->data['lastSession'] = $lastOpenSession;
        }

        $view->data['address-component'] = new \Modules\Admin\Theme\Backend\Components\AddressEditor\AddressView($this->app->l11nManager, $request, $response);
        $view->data['contact-component'] = new \Modules\Admin\Theme\Backend\Components\ContactEditor\ContactView($this->app->l11nManager, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrDepartmentList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/department-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002403001, $request, $response);

        $view->data['departments'] = DepartmentMapper::getAll()
            ->with('parent')
            ->where('unit', $this->app->unitId)
            ->executeGetArray();

        $histories = EmployeeHistoryMapper::getAll()
            ->where('department', \array_map(function (Department $department) : int { return $department->id; }, $view->data['departments']))
            ->executeGetArray();

        $stats = [];
        foreach ($histories as $employee) {
            if (!isset($stats[$employee->department->id])) {
                $stats[$employee->department->id] = 0;
            }

            ++$stats[$employee->department->id];
        }

        $view->data['stats'] = $stats;

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrPositionList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/position-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002404001, $request, $response);

        $departments = DepartmentMapper::getAll()
            ->where('unit', $this->app->unitId)
            ->executeGetArray();

        $view->data['positions'] = PositionMapper::getAll()
            ->with('parent')
            ->where('department', \array_map(function (Department $department) : int { return $department->id; }, $departments))
            ->executeGetArray();

        $histories = EmployeeHistoryMapper::getAll()
            ->where('department', \array_map(function (Department $department) : int { return $department->id; }, $departments))
            ->where('position', \array_map(function (Position $position) : int { return $position->id; }, $view->data['positions']))
            ->executeGetArray();

        $stats = [];
        foreach ($histories as $employee) {
            if (!isset($stats[$employee->department->id])) {
                $stats[$employee->department->id] = 0;
            }

            ++$stats[$employee->department->id];
        }

        $view->data['stats'] = $stats;

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrPositionCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/position-create');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

        $accSelector               = new \Modules\Profile\Theme\Backend\Components\AccountGroupSelector\BaseView($this->app->l11nManager, $request, $response);
        $view->data['accSelector'] = $accSelector;

        return $view;
    }
}
