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

use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\Organization\Models\DepartmentMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\DataStorage\Database\Query\OrderType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
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
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffList(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

        $view->data['employees'] = EmployeeMapper::getAll()
            ->with('profile')
            ->with('profile/account')
            ->with('companyHistory')
            ->with('companyHistory/unit')
            ->execute();

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-create');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

        $accSelector               = new \Modules\Profile\Theme\Backend\Components\AccountGroupSelector\BaseView($this->app->l11nManager, $request, $response);
        $view->data['accSelector'] = $accSelector;

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffProfile(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-profile');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

        $employee = EmployeeMapper::get()
            ->with('profile')
            ->with('profile/account')
            ->with('companyHistory')
            ->with('companyHistory/unit')
            ->with('companyHistory/department')
            ->with('companyHistory/position')
            ->with('educationHistory')
            ->with('educationHistory/unit')
            ->with('educationHistory/department')
            ->with('educationHistory/position')
            ->with('workHistory')
            ->with('workHistory/unit')
            ->with('workHistory/department')
            ->with('workHistory/position')
            ->where('id', (int) $request->getData('id'))
            ->sort('companyHistory/start', OrderType::DESC)
            ->sort('educationHistory/start', OrderType::DESC)
            ->sort('workHistory/start', OrderType::DESC)
            ->execute();

        $view->data['employee'] = $employee;

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrDepartmentList(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/department-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002403001, $request, $response);

        $view->data['departments'] = DepartmentMapper::getAll();

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrPositionList(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/position-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002403001, $request, $response);

        $view->data['departments'] = DepartmentMapper::getAll();

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrPositionCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/position-create');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response);

        $accSelector               = new \Modules\Profile\Theme\Backend\Components\AccountGroupSelector\BaseView($this->app->l11nManager, $request, $response);
        $view->data['accSelector'] = $accSelector;

        return $view;
    }
}
