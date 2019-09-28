<?php declare(strict_types=1);
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */

use \Modules\HumanResourceManagement\Models\EmployeeActivityStatus;

/**
 * @var \phpOMS\Views\View $this
 */

echo $this->getData('nav')->render();
?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Employee'); ?></h1></header>
            <div class="inner">
                <form id="fEmployee" action="<?= \phpOMS\Uri\UriFactory::build('{/api}humanresource/staff'); ?>" method="put">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iStatus"><?= $this->getHtml('Status'); ?></label>
                        <tr><td><select id="iStatus" name="status">
                                    <option value="<?= $this->printHtml(EmployeeActivityStatus::ACTIVE); ?>"><?= $this->getHtml('Active'); ?>
                                    <option value="<?= $this->printHtml(EmployeeActivityStatus::INACTIVE); ?>"><?= $this->getHtml('Inactive'); ?>
                                </select>
                        <tr><td><label for="iName1"><?= $this->getHtml('Name1', 'Admin'); ?></label>
                        <tr><td><input id="iName1" name="name1" type="text" placeholder="&#xf007; Donald" required>
                        <tr><td><label for="iName2"><?= $this->getHtml('Name2', 'Admin'); ?></label>
                        <tr><td><input id="iName2" name="name2" type="text" placeholder="&#xf007; Fauntleroy">
                        <tr><td><label for="iName3"><?= $this->getHtml('Name3', 'Admin'); ?></label>
                        <tr><td><input id="iName3" name="name3" type="text" placeholder="&#xf007; Duck">
                        <tr><td><label for="iAddress"><?= $this->getHtml('Address', 'Profile') ?></label>
                        <tr><td><input type="text" id="iAddress" name="address">
                        <tr><td><label for="iZip"><?= $this->getHtml('Zip', 'Profile') ?></label>
                        <tr><td><input type="text" id="iZip" name="zip">
                        <tr><td><label for="iCity"><?= $this->getHtml('City', 'Profile') ?></label>
                        <tr><td><input type="text" id="iCity" name="city">
                        <tr><td><label for="iCountry"><?= $this->getHtml('Country', 'Profile') ?></label>
                        <tr><td><input type="text" id="iCountry" name="country">
                        <tr><td><label for="iBirthday"><?= $this->getHtml('Birthday', 'Profile'); ?></label>
                        <tr><td><input id="iBirthday" name="pirthday" type="text">
                        <tr><td><label for="iPhone"><?= $this->getHtml('Phone', 'Profile'); ?></label>
                        <tr><td><input id="iPhone" name="phone" type="text">
                        <tr><td><label for="iEmail"><?= $this->getHtml('Email', 'Admin'); ?></label>
                        <tr><td><input id="iEmail" name="email" type="email" placeholder="&#xf0e0; d.duck@duckburg.com">
                        <tr><td><label for="iUnit"><?= $this->getHtml('Unit', 'Organization'); ?></label>
                        <tr><td><input id="iUnit" name="unit" type="text">
                        <tr><td><label for="iPosition"><?= $this->getHtml('Position', 'Organization'); ?></label>
                        <tr><td><input id="iPosition" name="position" type="text">
                        <tr><td><label for="iStart"><?= $this->getHtml('Start'); ?></label>
                        <tr><td><input id="iStart" name="start" type="datetime-local">
                        <tr><td><label for="iEnd"><?= $this->getHtml('End'); ?></label>
                        <tr><td><input id="iEnd" name="end" type="datetime-local">
                        <tr><td><input id="employee-create-submit" name="createSubmit" type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('CreateFromAccount'); ?></h1></header>
            <div class="inner">
                <form id="fAccount" action="<?= \phpOMS\Uri\UriFactory::build('{/api}humanresource/staff'); ?>" method="put">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iAccount"><?= $this->getHtml('Account', 'Admin'); ?></label>
                        <tr><td><?= $this->getData('accSelector')->render('iAccount', 'accounts', true); ?>
                        <tr><td><input id="employee-create-submit" name="createSubmit" type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>
