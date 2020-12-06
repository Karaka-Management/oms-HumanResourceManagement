<?php declare(strict_types=1);

use Modules\HumanResourceManagement\Models\NullEmployeeHistory;

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
/**
 * @var \phpOMS\Views\View $this
 */

$employees = $this->getData('employees');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Staff'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <table id="employeeList" class="default">
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Unit'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Position'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Department'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Status'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                <tbody>
                <?php $c = 0; foreach ($employees as $key => $value) : ++$c;
                    $url = \phpOMS\Uri\UriFactory::build('{/prefix}humanresource/staff/profile?{?}&id=' . $value->getId()); ?>
                    <tr tabindex="0" data-href="<?= $url; ?>">
                        <td data-label="<?= $this->getHtml('ID', '0', '0'); ?>"><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                        <td data-label="<?= $this->getHtml('Name'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml(
                                \sprintf('%3$s %2$s %1$s', $value->profile->account->name1, $value->profile->account->name2, $value->profile->account->name3)
                            ); ?></a>
                        <td><?= $this->printHtml($value->getNewestHistory()->getUnit()->name); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->getPosition()->name); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->getDepartment()->name); ?>
                        <td><?= !($value->getNewestHistory() instanceof NullEmployeeHistory) ? $this->getHtml('Active') : $this->getHtml('Inactive'); ?>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                    <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
