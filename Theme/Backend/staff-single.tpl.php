<?php
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
declare(strict_types=1);


use Modules\Media\Models\NullMedia;
use phpOMS\Uri\UriFactory;

$employee = $this->getData('employee');
$history = $employee->getHistorY();
$recentHistory = $employee->getNewestHistory();

echo $this->getData('nav')->render(); ?>

<div class="tabview tab-2">
    <div class="box wf-100 col-xs-12">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('General'); ?></label></li>
            <li><label for="c-tab-2"><?= $this->getHtml('Clocking'); ?></label></li>
            <li><label for="c-tab-3"><?= $this->getHtml('Documents'); ?></label></li>
            <li><label for="c-tab-4"><?= $this->getHtml('Contracts'); ?></label></li>
            <li><label for="c-tab-5"><?= $this->getHtml('Remarks'); ?></label></li>
            <li><label for="c-tab-6"><?= $this->getHtml('Evaluations'); ?></label></li>
            <li><label for="c-tab-7"><?= $this->getHtml('Education'); ?></label></li>
            <li><label for="c-tab-8"><?= $this->getHtml('Work'); ?></label></li>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2" checked>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section itemscope itemtype="http://schema.org/Person" class="box wf-100">
                        <header><h1><span itemprop="familyName"><?= $this->printHtml($employee->getProfile()->getAccount()->getName2()); ?></span>, <span itemprop="givenName"><?= $this->printHtml($employee->getProfile()->getAccount()->getName1()); ?></span></h1></header>
                        <div class="inner">
                            <!-- @formatter:off -->
                            <span class="rf">
                                    <img class="m-profile rf"
                                        alt="<?= $this->getHtml('ProfileImage'); ?>"
                                        itemprop="logo"
                                        data-lazyload="<?=
                                            $employee->getImage() instanceof NullMedia ?
                                                $employee->getProfile()->getImage() instanceof NullMedia ?
                                                    UriFactory::build('Web/Backend/img/user_default_' . \mt_rand(1, 6) .'.png') :
                                                    UriFactory::build('{/prefix}' . $employee->getProfile()->getImage()->getPath()) :
                                                UriFactory::build('{/prefix}' . $employee->getImage()->getPath()); ?>"
                                    >
                                </span>
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
                                            <td itemprop="email"><a href="mailto:<?= $this->printHtml($employee->getProfile()->getAccount()->getEmail()); ?>"><?= $this->printHtml($employee->getProfile()->getAccount()->getEmail()); ?></a>
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
                                            <td><span class="tag green"><?= !($recentHistory instanceof NullEmployeeHistory) ? $this->getHtml('Active') : $this->getHtml('Inactive'); ?></span>
                                    </table>
                                <!-- @formatter:on -->
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box wf-100 x-overflow">
                        <table id="historyList" class="default">
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
        </div>
        <input type="radio" id="c-tab-2" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="box wf-100">
                    <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
                        <div class="inner">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-3" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="box wf-100">
                    <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
                        <div class="inner">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-4" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="box wf-100">
                    <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
                        <div class="inner">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-5" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="box wf-100">
                    <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
                        <div class="inner">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-6" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="box wf-100">
                    <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
                        <div class="inner">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-7" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="box wf-100">
                    <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
                        <div class="inner">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-8" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="box wf-100">
                    <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
                        <div class="inner">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>