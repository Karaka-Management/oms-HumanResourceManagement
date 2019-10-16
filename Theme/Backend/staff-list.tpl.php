<?php declare(strict_types=1);

use Modules\HumanResourceManagement\Models\NullEmployeeHistory;

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
/**
 * @var \phpOMS\Views\View $this
 */

$employees = $this->getData('employees');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table id="employeeList" class="default">
                <caption><?= $this->getHtml('Staff') ?><i class="fa fa-download floatRight download btn"></i></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td class="wf-100"><?= $this->getHtml('Name') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Unit') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Position') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Department') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Status') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                <tfoot>
                <tr><td colspan="6">
                <tbody>
                <?php $c = 0; foreach ($employees as $key => $value) : ++$c;
                    $url = \phpOMS\Uri\UriFactory::build('{/prefix}humanresource/staff/profile?{?}&id=' . $value->getId()); ?>
                    <tr data-href="<?= $url; ?>">
                        <td data-label="<?= $this->getHtml('ID', '0', '0') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                        <td data-label="<?= $this->getHtml('Name') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getProfile()->getAccount()->getName1()); ?></a>
                        <td><?= $this->printHtml($value->getNewestHistory()->getUnit()->getName()); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->getPosition()->getName()); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->getDepartment()->getName()); ?>
                        <td><?= !($value->getNewestHistory() instanceof NullEmployeeHistory) ? $this->getHtml('Active') : $this->getHtml('Inactive'); ?>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                    <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
