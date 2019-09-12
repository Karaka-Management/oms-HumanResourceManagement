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

$employee = $this->getData('employee');
$history = $employee->getHistorY();
$recentHistory = $employee->getNewestHistory();

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section itemscope itemtype="http://schema.org/Person" class="box wf-100">
            <header><h1><span itemprop="familyName"><?= $this->printHtml($employee->getAccount()->getName3()); ?></span>, <span itemprop="givenName"><?= $this->printHtml($employee->getAccount()->getName1()); ?></span></h1></header>
            <div class="inner">
                <!-- @formatter:off -->
                        <table class="list">
                            <tr>
                                <th><?= $this->getHtml('Position') ?>
                                <td itemprop="jobTitle"><?= $this->printHtml($recentHistory->getPosition()->getName()); ?>
                            <tr>
                                <th><?= $this->getHtml('Department') ?>
                                <td itemprop="jobTitle"><?= $this->printHtml($recentHistory->getDepartment()->getName()); ?>
                            <tr>
                                <th><?= $this->getHtml('Unit') ?>
                                <td itemprop="jobTitle"><?= $this->printHtml($recentHistory->getUnit()->getName()); ?>
                            <tr>
                                <th><?= $this->getHtml('Birthday') ?>
                                <td itemprop="birthDate">06.09.1934
                            <tr>
                                <th><?= $this->getHtml('Email') ?>
                                <td itemprop="email"><a href="mailto:>donald.duck@email.com<"><?= $this->printHtml($employee->getAccount()->getEmail()); ?></a>
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
                                <td><span class="tag green"><?= $this->printHtml($employee->getAccount()->getStatus()); ?></span>
                        </table>
                    <!-- @formatter:on -->
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
        <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
            <div class="inner">
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
            <div class="inner">
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <div class="box wf-100 x-overflow">
            <table id="taskList" class="default">
                <caption><?= $this->getHtml('History') ?><i class="fa fa-download floatRight download btn"></i></caption>
                <thead>
                    <td><?= $this->getHtml('Start') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('End') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Unit') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Department') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td><?= $this->getHtml('Position') ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                <tfoot>
                <tbody>
                <?php foreach ($history as $hist) : ?>
                    <tr><td><?= $hist->getStart()->format('Y-m-d'); ?>
                        <td><?= $hist->getEnd() === null ? '' : $hist->getEnd()->format('Y-m-d'); ?>
                        <td><?= $this->printHtml($hist->getUnit()->getName()); ?>
                        <td><?= $this->printHtml($hist->getDepartment()->getName()); ?>
                        <td><?= $this->printHtml($hist->getPosition()->getName()); ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
