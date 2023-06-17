<?php
/**
 * Jingga
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

$employee         = $this->data['employee'];
$history          = $employee->getHistory();
$educationHistory = $employee->getEducationHistory();
$workHistory      = $employee->getWorkHistory();
$recentHistory    = $employee->getNewestHistory();

echo $this->data['nav']->render(); ?>

<div class="tabview tab-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('General'); ?></label></li>
            <li><label for="c-tab-2"><?= $this->getHtml('Clocking'); ?></label></li>
            <li><label for="c-tab-3"><?= $this->getHtml('Documents'); ?></label></li>
            <li><label for="c-tab-4"><?= $this->getHtml('Contracts'); ?></label></li>
            <li><label for="c-tab-5"><?= $this->getHtml('Remarks'); ?></label></li>
            <li><label for="c-tab-6"><?= $this->getHtml('Evaluations'); ?></label></li>
            <li><label for="c-tab-7"><?= $this->getHtml('Salary'); ?></label></li>
            <li><label for="c-tab-8"><?= $this->getHtml('Education'); ?></label></li>
            <li><label for="c-tab-9"><?= $this->getHtml('Work'); ?></label></li>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-1' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section itemscope itemtype="http://schema.org/Person" class="portlet">
                        <div class="portlet-head"><span itemprop="familyName"><?= $this->printHtml($employee->profile->account->name2); ?></span>, <span itemprop="givenName"><?= $this->printHtml($employee->profile->account->name1); ?></span></div>
                        <div class="portlet-body">
                            <!-- @formatter:off -->
                            <span class="rf">
                                    <img class="m-profile rf"
                                        alt="<?= $this->getHtml('ProfileImage'); ?>"
                                        itemprop="logo" loading="lazy"
                                        src="<?=
                                            $employee->image->id === 0 ?
                                                ($employee->profile->image->id === 0 ?
                                                    UriFactory::build('Web/Backend/img/user_default_' . \mt_rand(1, 6) .'.png') :
                                                    UriFactory::build('{/base}/' . $employee->profile->image->getPath())) :
                                                UriFactory::build('{/base}/' . $employee->image->getPath()); ?>"
                                    >
                                </span>
                                    <table class="list">
                                        <tr>
                                            <th><?= $this->getHtml('Position'); ?>
                                            <td itemprop="jobTitle"><?= $this->printHtml($recentHistory->position->name); ?>
                                        <tr>
                                            <th><?= $this->getHtml('Department'); ?>
                                            <td itemprop="jobTitle"><?= $this->printHtml($recentHistory->department->name); ?>
                                        <tr>
                                            <th><?= $this->getHtml('Unit'); ?>
                                            <td itemprop="jobTitle"><?= $this->printHtml($recentHistory->unit->name); ?>
                                        <tr>
                                            <th><?= $this->getHtml('Birthday'); ?>
                                            <td itemprop="birthDate">06.09.1934
                                        <tr>
                                            <th><?= $this->getHtml('Email'); ?>
                                            <td itemprop="email"><a href="mailto:<?= $this->printHtml($employee->profile->account->getEmail()); ?>"><?= $this->printHtml($employee->profile->account->getEmail()); ?></a>
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
                                            <th><?= $this->getHtml('Phone'); ?>
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
                                            <th><?= $this->getHtml('Status'); ?>
                                            <td><span class="tag green"><?= $recentHistory->id > 0 ? $this->getHtml('Active') : $this->getHtml('Inactive'); ?></span>
                                    </table>
                                <!-- @formatter:on -->
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet x-overflow">
                        <div class="portlet-head"><?= $this->getHtml('History'); ?><i class="lni lni-download download btn end-xs"></i></div>
                        <table id="historyList" class="default">
                            <thead>
                                <td><?= $this->getHtml('Start'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('End'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('Unit'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('Department'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('Position'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                            <tbody>
                            <?php foreach ($history as $hist) : ?>
                                <tr><td><?= $hist->start->format('Y-m-d'); ?>
                                    <td><?= $hist->end === null ? '' : $hist->end->format('Y-m-d'); ?>
                                    <td><?= $this->printHtml($hist->unit->name); ?>
                                    <td><?= $this->printHtml($hist->department->name); ?>
                                    <td><?= $this->printHtml($hist->position->name); ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-2" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-2' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Clocking'); ?></div>
                        <div class="portlet-body">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-3" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-3' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Documents'); ?></div>
                        <div class="portlet-body">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-4" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-4' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Contracts'); ?></div>
                        <div class="portlet-body">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-5" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-5' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Remarks'); ?></div>
                        <div class="portlet-body">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-6" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-6' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Evaluations'); ?></div>
                        <div class="portlet-body">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-7" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-7' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
            </div>
        </div>
        <input type="radio" id="c-tab-8" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-7' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet x-overflow">
                        <div class="portlet-head"><?= $this->getHtml('Education'); ?><i class="lni lni-download download btn end-xs"></i></div>
                        <table id="historyList" class="default">
                            <thead>
                                <td><?= $this->getHtml('Start'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('End'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('Title'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('Address'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                            <tbody>
                            <?php foreach ($educationHistory as $hist) : ?>
                                <tr><td><?= $hist->start->format('Y-m-d'); ?>
                                    <td><?= $hist->end === null ? '' : $hist->end->format('Y-m-d'); ?>
                                    <td><?= $this->printHtml($hist->educationTitle); ?>
                                    <td><?= $this->printHtml($hist->address->name); ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-9" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-8' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet x-overflow">
                        <div class="portlet-head"><?= $this->getHtml('Work'); ?><i class="lni lni-download download btn end-xs"></i></div>
                        <table id="historyList" class="default">
                            <thead>
                                <td><?= $this->getHtml('Start'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('End'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('Title'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                                <td><?= $this->getHtml('Address'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                            <tbody>
                            <?php foreach ($workHistory as $hist) : ?>
                                <tr><td><?= $hist->start->format('Y-m-d'); ?>
                                    <td><?= $hist->end === null ? '' : $hist->end->format('Y-m-d'); ?>
                                    <td><?= $this->printHtml($hist->jobTitle); ?>
                                    <td><?= $this->printHtml($hist->address->name); ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>