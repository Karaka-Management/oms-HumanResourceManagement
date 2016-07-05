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
echo $this->getData('nav')->render(); ?>

<section itemscope itemtype="http://schema.org/Person" class="box w-33">
    <header><h1><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Employee'); ?></h1></header>
    <div class="inner">
        <!-- @formatter:off -->
                <table class="list">
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Name'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>, <span itemprop="givenName"><?= $account->getName1(); ?></span>
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Position'); ?>
                        <td itemprop="jobTitle">Sailor
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Department'); ?>
                        <td itemprop="jobTitle">Sailor
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Birthday'); ?>
                        <td itemprop="birthDate">06.09.1934
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Email'); ?>
                        <td itemprop="email"><a href="mailto:>donald.duck@email.com<"><?= $account->getEmail(); ?></a>
                    <tr>
                        <th>Address
                        <td>
                    <tr>
                        <th class="vT">Private
                        <td itemprop="address">SMALLSYS INC<br>795 E DRAGRAM<br>TUCSON AZ 85705<br>USA
                    <tr>
                        <th class="vT">Work
                        <td itemprop="address">SMALLSYS INC<br>795 E DRAGRAM<br>TUCSON AZ 85705<br>USA
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Phone'); ?>
                        <td>
                    <tr>
                        <th>Private
                        <td itemprop="telephone">+01 12345-4567
                    <tr>
                        <th>Mobile
                        <td itemprop="telephone">+01 12345-4567
                    <tr>
                        <th>Work
                        <td itemprop="telephone">+01 12345-4567
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Status'); ?>
                        <td><span class="tag green"><?= $account->getStatus(); ?></span>
                </table>
            <!-- @formatter:on -->
    </div>
</section>

<section class="box w-33">
    <header><h1><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Overview'); ?></h1></header>
    <div class="inner">
        <!-- @formatter:off -->
                <table class="list">
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Start'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'End'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Hours'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Vacation'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Salary'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                </table>
            <!-- @formatter:on -->
    </div>
</section>

<div class="box w-100">
    <table class="table">
        <caption><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Working'); ?></caption>
        <thead>
        <tr>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Start'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'End'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Position'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Department'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Salary'); ?>
        <tfoot>
        <tr><td colspan="4"><?= $footerView->render(); ?>
        <tbody>
        <?php $c = 0; foreach ($employees as $key => $value) : $c++;
            $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/admin/group/settings?id=' . $value->getId()); ?>
            <tr>
                <td><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                <td><a href="<?= $url; ?>"><?= $value->getNewestHistory()->getPosition(); ?></a>
                <td><a href="<?= $url; ?>"><?= $value->getNewestHistory()->getPosition(); ?></a>
        <?php endforeach; ?>
        <?php if($c === 0) : ?>
            <tr><td colspan="4" class="empty"><?= $this->l11n->getText(0, 'Backend', 'Empty'); ?>
        <?php endif; ?>
    </table>
</div>

<div class="box w-100">
    <table class="table">
        <caption><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Timing'); ?></caption>
        <thead>
        <tr>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Start'); ?>
            <td><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'End'); ?>
            <td class="wf-100"><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Type'); ?>
        <tfoot>
        <tr><td colspan="4"><?= $footerView->render(); ?>
        <tbody>
        <?php $c = 0; foreach ($employees as $key => $value) : $c++;
            $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/admin/group/settings?id=' . $value->getId()); ?>
            <tr>
                <td><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                <td><a href="<?= $url; ?>"><?= $value->getNewestHistory()->getPosition(); ?></a>
                <td><a href="<?= $url; ?>"><?= $value->getNewestHistory()->getPosition(); ?></a>
        <?php endforeach; ?>
        <?php if($c === 0) : ?>
            <tr><td colspan="4" class="empty"><?= $this->l11n->getText(0, 'Backend', 'Empty'); ?>
        <?php endif; ?>
    </table>
</div>

<section class="box w-33">
    <header><h1><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Salary'); ?></h1></header>
    <div class="inner">
        <!-- @formatter:off -->
                <table class="list">
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Date'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'SalaryType'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                    <tr>
                        <th><?= $this->l11n->getText('HumanResourceManagement', 'Backend', 'Amount'); ?>
                        <td><span itemprop="familyName"><?= $account->getName3(); ?></span>
                </table>
            <!-- @formatter:on -->
    </div>
</section>
