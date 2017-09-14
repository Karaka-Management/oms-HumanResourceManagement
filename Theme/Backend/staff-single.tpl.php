<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
echo $this->getData('nav')->render(); ?>

<section itemscope itemtype="http://schema.org/Person" class="box w-33">
    <header><h1><?= $this->getHtml('Employee') ?></h1></header>
    <div class="inner">
        <!-- @formatter:off -->
                <table class="list">
                    <tr>
                        <th><?= $this->getHtml('Name') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>, <span itemprop="givenName"><?= $this->printHtml($account->getName1()); ?></span>
                    <tr>
                        <th><?= $this->getHtml('Position') ?>
                        <td itemprop="jobTitle">Sailor
                    <tr>
                        <th><?= $this->getHtml('Department') ?>
                        <td itemprop="jobTitle">Sailor
                    <tr>
                        <th><?= $this->getHtml('Birthday') ?>
                        <td itemprop="birthDate">06.09.1934
                    <tr>
                        <th><?= $this->getHtml('Email') ?>
                        <td itemprop="email"><a href="mailto:>donald.duck@email.com<"><?= $this->printHtml($account->getEmail()); ?></a>
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
                        <th><?= $this->getHtml('Phone') ?>
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
                        <th><?= $this->getHtml('Status') ?>
                        <td><span class="tag green"><?= $this->printHtml($account->getStatus()); ?></span>
                </table>
            <!-- @formatter:on -->
    </div>
</section>

<section class="box w-33">
    <header><h1><?= $this->getHtml('Overview') ?></h1></header>
    <div class="inner">
        <!-- @formatter:off -->
                <table class="list">
                    <tr>
                        <th><?= $this->getHtml('Start') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                    <tr>
                        <th><?= $this->getHtml('End') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                    <tr>
                        <th><?= $this->getHtml('Hours') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                    <tr>
                        <th><?= $this->getHtml('Vacation') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                    <tr>
                        <th><?= $this->getHtml('Salary') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                </table>
            <!-- @formatter:on -->
    </div>
</section>

<div class="box w-100">
    <table class="table red">
        <caption><?= $this->getHtml('Working') ?></caption>
        <thead>
        <tr>
            <td><?= $this->getHtml('Start') ?>
            <td><?= $this->getHtml('End') ?>
            <td><?= $this->getHtml('Position') ?>
            <td><?= $this->getHtml('Department') ?>
            <td><?= $this->getHtml('Salary') ?>
        <tfoot>
        <tr><td colspan="4"><?= $footerView->render(); ?>
        <tbody>
        <?php $c = 0; foreach ($employees as $key => $value) : $c++;
            $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/admin/group/settings?{?}&id=' . $value->getId()); ?>
            <tr>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNewestHistory()->getPosition()); ?></a>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNewestHistory()->getPosition()); ?></a>
        <?php endforeach; ?>
        <?php if($c === 0) : ?>
            <tr><td colspan="4" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
        <?php endif; ?>
    </table>
</div>

<div class="box w-100">
    <table class="table red">
        <caption><?= $this->getHtml('Timing') ?></caption>
        <thead>
        <tr>
            <td><?= $this->getHtml('Start') ?>
            <td><?= $this->getHtml('End') ?>
            <td class="wf-100"><?= $this->getHtml('Type') ?>
        <tfoot>
        <tr><td colspan="4"><?= $footerView->render(); ?>
        <tbody>
        <?php $c = 0; foreach ($employees as $key => $value) : $c++;
            $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/admin/group/settings?{?}&id=' . $value->getId()); ?>
            <tr>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNewestHistory()->getPosition()); ?></a>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNewestHistory()->getPosition()); ?></a>
        <?php endforeach; ?>
        <?php if($c === 0) : ?>
            <tr><td colspan="4" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
        <?php endif; ?>
    </table>
</div>

<section class="box w-33">
    <header><h1><?= $this->getHtml('Salary') ?></h1></header>
    <div class="inner">
        <!-- @formatter:off -->
                <table class="list">
                    <tr>
                        <th><?= $this->getHtml('Date') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                    <tr>
                        <th><?= $this->getHtml('SalaryType') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                    <tr>
                        <th><?= $this->getHtml('Amount') ?>
                        <td><span itemprop="familyName"><?= $this->printHtml($account->getName3()); ?></span>
                </table>
            <!-- @formatter:on -->
    </div>
</section>
