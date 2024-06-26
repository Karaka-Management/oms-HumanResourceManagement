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

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View $this
 */

$employees = $this->data['employees'];

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Staff'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="employeeList" class="default sticky">
                <thead>
                <tr>
                    <td>
                    <td><?= $this->getHtml('ID', '0', '0'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                    <td><?= $this->getHtml('Unit'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                    <td><?= $this->getHtml('Position'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                    <td><?= $this->getHtml('Department'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                    <td><?= $this->getHtml('Status'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                <tbody>
                <?php $c = 0; foreach ($employees as $key => $value) : ++$c;
                    $url = UriFactory::build('{/base}/humanresource/staff/view?{?}&id=' . $value->id); ?>
                    <tr tabindex="0" data-href="<?= $url; ?>">
                        <td><a href="<?= $url; ?>"><img alt="<?= $this->getHtml('IMG_alt_user'); ?>" width="30" loading="lazy" class="profile-image"
                            src="<?= $value->image->id === 0
                                ? ($value->profile->image->id === 0
                                    ? UriFactory::build($this->data['defaultImage']->getPath())
                                    : UriFactory::build($value->profile->image->getPath()))
                                : UriFactory::build($value->image->getPath()); ?>"></a>
                        <td data-label="<?= $this->getHtml('ID', '0', '0'); ?>"><a href="<?= $url; ?>"><?= $value->id; ?></a>
                        <td data-label="<?= $this->getHtml('Name'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml(
                                \sprintf('%3$s %2$s %1$s', $value->profile->account->name1, $value->profile->account->name2, $value->profile->account->name3)
                            ); ?></a>
                        <td><?= $this->printHtml($value->getNewestHistory()->unit->name); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->position->name); ?>
                        <td><?= $this->printHtml($value->getNewestHistory()->department->name); ?>
                        <td><?= $value->getNewestHistory()->id > 0 ? $this->getHtml('Active') : $this->getHtml('Inactive'); ?>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                    <tr><td colspan="7" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
                <tr class="hl-3">
                    <td colspan="6"><?= $this->getHtml('Total'); ?>
                    <td><?= $c; ?>
            </table>
            </div>
        </section>
    </div>
</div>
