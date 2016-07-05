<?php
/**
 * Orange Management
 *
 * PHP Version 7.0
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
/**
 * @var \phpOMS\Views\View $this
 */

$footerView = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');

$footerView->setPages(1 / 25);
$footerView->setPage(1);
$footerView->setResults(1);

$employees = $this->getData('employees');

echo $this->getData('nav')->render(); ?>

<div class="box w-100">
    <table class="table">
        <caption><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Staff'); ?></caption>
        <thead>
        <tr>
            <td><?= $this->l11n->getText(0, 'Backend', 'ID'); ?>
            <td class="wf-100"><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Name'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Position'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Department'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Status'); ?>
        <tfoot>
        <tr><td colspan="5"><?= $footerView->render(); ?>
        <tbody>
        <?php $c = 0; foreach ($employees as $key => $value) : $c++;
            $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/admin/group/settings?id=' . $value->getId()); ?>
            <tr>
                <td><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                <td><a href="<?= $url; ?>"><?= $value->getNewestHistory()->getPosition(); ?></a>
                <td><a href="<?= $url; ?>"><?= $value->getNewestHistory()->getPosition(); ?></a>
                <td><a href="<?= $url; ?>"><?= $value->getNewestStatus()->getStatus(); ?></a>
        <?php endforeach; ?>
        <?php if($c === 0) : ?>
            <tr><td colspan="5" class="empty"><?= $this->l11n->getText(0, 'Backend', 'Empty'); ?>
        <?php endif; ?>
    </table>
</div>
