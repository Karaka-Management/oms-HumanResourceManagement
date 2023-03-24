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

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View $this
 */

$footerView = new \phpOMS\Views\PaginationView($this->l11nManager, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');

$footerView->setPages(25);
$footerView->setPage(1);
$footerView->setResults(1);

$departments = $this->getData('departments');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Departments'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <div class="slider">
            <table class="default sticky">
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?>
                    <td><?= $this->getHtml('Employees'); ?>
                    <td><?= $this->getHtml('Parent'); ?>
                <tbody>
                <?php $c = 0; foreach ($departments as $key => $value) : ++$c;
                $url     = UriFactory::build('{/base}/hr/department/single?{?}&id=' . $value->getId()); ?>
                <tr tabindex="0" data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('ID', '0', '0'); ?>"><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                    <td data-label="<?= $this->getHtml('Name'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->name); ?></a>
                    <td data-label="<?= $this->getHtml('Employees'); ?>">
                    <td data-label="<?= $this->getHtml('Parent'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->parent->name); ?></a>
                        <?php endforeach; ?>
                        <?php if ($c === 0) : ?>
                <tr><td colspan="4" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                        <?php endif; ?>
            </table>
            </div>
        </div>
    </div>
</div>
