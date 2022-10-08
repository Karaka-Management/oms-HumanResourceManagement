<?php

/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use Modules\HumanResourceManagement\Models\NullEmployeeHistory;
use Modules\Media\Models\NullMedia;
use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View $this
 */

$employees = $this->getData('employees');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Staff'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <div class="slider">
            <table id="employeeList" class="default sticky">
                <thead>
                <tr>
                    <td>
                    <td><?= $this->getHtml('ID', '0', '0'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Unit'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Position'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Department'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Status'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                <tbody>
                <?php $c = 0; foreach ($employees as $key => $value) : ++$c;
                    $url = UriFactory::build('{/prefix}humanresource/staff/profile?{?}&id=' . $value->getId()); ?>
                    <tr tabindex="0" data-href="<?= $url; ?>">
                        <td><a href="<?= $url; ?>"><img alt="<?= $this->getHtml('IMG_alt_staff'); ?>" width="30" loading="lazy" class="profile-image"
                            src="<?=
                                    $value->profile->image instanceof NullMedia ?
                                        UriFactory::build('Web/Backend/img/user_default_' . \mt_rand(1, 6) .'.png') :
                                        UriFactory::build('{/prefix}' . $value->profile->image->getPath()); ?>"></a>
                        <td data-label="<?= $this->getHtml('ID', '0', '0'); ?>"><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                        <td data-label="<?= $this->getHtml('Name'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml(
                                \sprintf('%3$s %2$s %1$s', $value->profile->account->name1, $value->profile->account->name2, $value->profile->account->name3)
                            ); ?></a>
                        <td><?= $this->printHtml($value->getNewestHistory()->unit->name); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->position->name); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->department->name); ?>
                        <td><?= !($value->getNewestHistory() instanceof NullEmployeeHistory) ? $this->getHtml('Active') : $this->getHtml('Inactive'); ?>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                    <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
        </div>
    </div>
</div>
