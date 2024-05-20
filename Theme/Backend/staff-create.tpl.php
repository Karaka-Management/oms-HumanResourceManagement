<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use \Modules\HumanResourceManagement\Models\EmployeeActivityStatus;

/**
 * @var \phpOMS\Views\View $this
 */

echo $this->data['nav']->render();
?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <form id="fEmployee" action="<?= \phpOMS\Uri\UriFactory::build('{/api}humanresource/staff?csrf={$CSRF}'); ?>" method="put">
                <div class="portlet-head"><?= $this->getHtml('Employee'); ?></div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="iStatus"><?= $this->getHtml('Status'); ?></label>
                        <select id="iStatus" name="status">
                            <option value="<?= EmployeeActivityStatus::ACTIVE; ?>"><?= $this->getHtml('Active'); ?>
                            <option value="<?= EmployeeActivityStatus::INACTIVE; ?>"><?= $this->getHtml('Inactive'); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="iName1"><?= $this->getHtml('Name1', 'Admin', 'Backend'); ?></label>
                        <input type="text" id="iName1" name="name1" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="iName2"><?= $this->getHtml('Name2', 'Admin', 'Backend'); ?></label>
                        <input type="text" id="iName2" name="name2" value="">
                    </div>

                    <div class="form-group">
                        <label for="iName3"><?= $this->getHtml('Name3', 'Admin', 'Backend'); ?></label>
                        <input type="text" id="iName3" name="name3" value="">
                    </div>
                </div>
                <div class="portlet-foot">
                    <input type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>" name="employee-client">
                </div>
            </form>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <form id="fAccount" action="<?= \phpOMS\Uri\UriFactory::build('{/api}humanresource/staff?csrf={$CSRF}'); ?>" method="put">
                <div class="portlet-head"><?= $this->getHtml('CreateFromAccount'); ?></div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="iAccount"><?= $this->getHtml('Account', 'Admin'); ?></label>
                        <?= $this->getData('accSelector')->render('iAccount', 'accounts', true); ?>
                    </div>
                </div>
                <div class="portlet-foot">
                    <input type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>" name="employee-client">
                </div>
            </form>
        </section>
    </div>
</div>
