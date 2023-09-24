<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\tests\Controller;

use Model\CoreSettings;
use Modules\Admin\Models\AccountPermission;
use Modules\Organization\Models\Department;
use Modules\Organization\Models\DepartmentMapper;
use Modules\Organization\Models\NullUnit;
use Modules\Organization\Models\Position;
use Modules\Organization\Models\PositionMapper;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\ISO3166TwoEnum;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\RnG\DateTime;
use phpOMS\Utils\TestUtils;

/**
 * @testdox Modules\HumanResourceManagement\tests\Controller\ApiControllerTest: HumanResourceManagement api controller
 *
 * @internal
 */
final class ApiControllerTest extends \PHPUnit\Framework\TestCase
{
    protected ApplicationAbstract $app;

    /**
     * @var \Modules\HumanResourceManagement\Controller\ApiController
     */
    protected ModuleAbstract $module;

    protected static int $employee = 0;

    public static function setUpBeforeClass() : void
    {
        $department              = new Department();
        $department->name        = 'HRMgmtDepartmentTest';
        $department->description = 'Description';
        $department->unit        = new NullUnit(1);
        DepartmentMapper::create()->execute($department);

        $position              = new Position();
        $position->name        = 'HRMgmtPositionTest';
        $position->description = 'Description';
        PositionMapper::create()->execute($position);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $this->app->dbPool          = $GLOBALS['dbpool'];
        $this->app->unitId          = 1;
        $this->app->accountManager  = new AccountManager($GLOBALS['session']);
        $this->app->appSettings     = new CoreSettings();
        $this->app->moduleManager   = new ModuleManager($this->app, __DIR__ . '/../../../../Modules/');
        $this->app->dispatcher      = new Dispatcher($this->app);
        $this->app->eventManager    = new EventManager($this->app->dispatcher);
        $this->app->eventManager->importFromFile(__DIR__ . '/../../../../Web/Api/Hooks.php');
        $this->app->sessionManager = new HttpSession(36000);
        $this->app->l11nManager    = new L11nManager();

        $account = new Account();
        TestUtils::setMember($account, 'id', 1);

        $permission       = new AccountPermission();
        $permission->unit = 1;
        $permission->app  = 1;
        $permission->setPermission(
            PermissionType::READ
            | PermissionType::CREATE
            | PermissionType::MODIFY
            | PermissionType::DELETE
            | PermissionType::PERMISSION
        );

        $account->addPermission($permission);

        $this->app->accountManager->add($account);
        $this->app->router = new WebRouter();

        $this->module = $this->app->moduleManager->get('HumanResourceManagement');

        TestUtils::setMember($this->module, 'app', $this->app);
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeFromAccountCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('profiles', '1');

        // can create multiple accounts if profiles is a list of ids e.g. 1,2,3
        $this->module->apiEmployeeCreate($request, $response);
        self::assertGreaterThan(0, self::$employee = $response->get('')['response'][0]->id);
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testNewEmployeeCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('name1', 'NewEmployee');

        $this->module->apiEmployeeCreate($request, $response);
        self::assertGreaterThan(0, self::$employee = $response->get('')['response']->id);
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testApiEmployeeCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiEmployeeCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeCreateFromAccountInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiEmployeeFromAccountCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testNewEmployeeCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiEmployeeNewCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @depends testEmployeeFromAccountCreate
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeHistoryCreate() : void
    {
        $start = DateTime::generateDateTime(
            (new \DateTime())->setTimestamp(\time() - \mt_rand(31622400 * 5, 31622400 * 10)),
            (new \DateTime())->setTimestamp(\time() - \mt_rand(31622400 * 1, 31622400 * 4))
        );

        $end = DateTime::generateDateTime(
            $start,
            (new \DateTime())->setTimestamp($start->getTimestamp() + \mt_rand(1, 31622400))
        );

        for ($i = 0; $i < 3; ++$i) {
            $response = new HttpResponse();
            $request  = new HttpRequest(new HttpUri(''));

            $request->header->account = 1;
            $request->setData('employee', self::$employee);
            $request->setData('start', $start->format('Y-m-d'));
            $request->setData('end', $i + 1 < 3 ? $end->format('Y-m-d') : null);
            $request->setData('unit', 1);
            $request->setData('department', 1);
            $request->setData('position', 1);
            $this->module->apiEmployeeHistoryCreate($request, $response);
            self::assertGreaterThan(0, $response->get('')['response']->id);

            $start = clone $end;
            $end   = DateTime::generateDateTime(
                $start,
                (new \DateTime())->setTimestamp($start->getTimestamp() + \mt_rand(1, 31622400))
            );
        }
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeHistoryCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiEmployeeHistoryCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @depends testEmployeeFromAccountCreate
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeWorkHistoryCreate() : void
    {
        $start = DateTime::generateDateTime(
            (new \DateTime())->setTimestamp(\time() - \mt_rand(31622400 * 5, 31622400 * 10)),
            (new \DateTime())->setTimestamp(\time() - \mt_rand(31622400 * 1, 31622400 * 4))
        );

        $end = DateTime::generateDateTime(
            $start,
            (new \DateTime())->setTimestamp($start->getTimestamp() + \mt_rand(1, 31622400))
        );

        for ($i = 0; $i < 3; ++$i) {
            $response = new HttpResponse();
            $request  = new HttpRequest(new HttpUri(''));

            $request->header->account = 1;
            $request->setData('employee', self::$employee);
            $request->setData('start', $start->format('Y-m-d'));
            $request->setData('end', $i + 1 < 3 ? $end->format('Y-m-d') : null);
            $request->setData('title', 'Title: ' . $i);
            $request->setData('name', 'Address Name');
            $request->setData('address', 'Some test address');
            $request->setData('postal', \str_pad((string) \mt_rand(1000, 99999), 5, '0', \STR_PAD_LEFT));
            $request->setData('city', 'TestCity');
            $request->setData('country', ISO3166TwoEnum::getRandom());
            $request->setData('state', '');

            $this->module->apiEmployeeWorkHistoryCreate($request, $response);
            self::assertGreaterThan(0, $response->get('')['response']->id);

            $start = clone $end;
            $end   = DateTime::generateDateTime(
                $start,
                (new \DateTime())->setTimestamp($start->getTimestamp() + \mt_rand(1, 31622400))
            );
        }
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeWorkHistoryCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiEmployeeWorkHistoryCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @depends testEmployeeFromAccountCreate
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeEducationHistoryCreate() : void
    {
        $start = DateTime::generateDateTime(
            (new \DateTime())->setTimestamp(\time() - \mt_rand(31622400 * 5, 31622400 * 10)),
            (new \DateTime())->setTimestamp(\time() - \mt_rand(31622400 * 1, 31622400 * 4))
        );

        $end = DateTime::generateDateTime(
            $start,
            (new \DateTime())->setTimestamp($start->getTimestamp() + \mt_rand(1, 31622400))
        );

        for ($i = 0; $i < 3; ++$i) {
            $response = new HttpResponse();
            $request  = new HttpRequest(new HttpUri(''));

            $request->header->account = 1;
            $request->setData('employee', self::$employee);
            $request->setData('start', $start->format('Y-m-d'));
            $request->setData('end', $i + 1 < 3 ? $end->format('Y-m-d') : null);
            $request->setData('title', 'Title: ' . $i);
            $request->setData('score', (string) \mt_rand(0, 100));
            $request->setData('name', 'Address Name');
            $request->setData('address', 'Some test address');
            $request->setData('postal', \str_pad((string) \mt_rand(1000, 99999), 5, '0', \STR_PAD_LEFT));
            $request->setData('city', 'TestCity');
            $request->setData('country', ISO3166TwoEnum::getRandom());
            $request->setData('state', '');

            $this->module->apiEmployeeEducationHistoryCreate($request, $response);
            self::assertGreaterThan(0, $response->get('')['response']->id);

            $start = clone $end;
            $end   = DateTime::generateDateTime(
                $start,
                (new \DateTime())->setTimestamp($start->getTimestamp() + \mt_rand(1, 31622400))
            );
        }
    }

    /**
     * @covers Modules\HumanResourceManagement\Controller\ApiController
     * @group module
     */
    public function testEmployeeEducationHistoryCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiEmployeeEducationHistoryCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
