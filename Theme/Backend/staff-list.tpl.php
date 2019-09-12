<?php declare(strict_types=1);
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   TBD
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
            <table class="default">
                <caption><?= $this->getHtml('Staff') ?><i class="fa fa-download floatRight download btn"></i></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                    <td><?= $this->getHtml('Unit') ?>
                    <td><?= $this->getHtml('Position') ?>
                    <td><?= $this->getHtml('Department') ?>
                    <td><?= $this->getHtml('Status') ?>
                <tfoot>
                <tr><td colspan="5">
                <tbody>
                <?php $c = 0; foreach ($employees as $key => $value) : ++$c;
                    $url = \phpOMS\Uri\UriFactory::build('{/prefix}humanresource/staff/profile?{?}&id=' . $value->getId()); ?>
                    <tr data-href="<?= $url; ?>">
                        <td data-label="<?= $this->getHtml('ID', '0', '0') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                        <td data-label="<?= $this->getHtml('Name') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getAccount()->getName1()); ?></a>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                    <tr><td colspan="5" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
