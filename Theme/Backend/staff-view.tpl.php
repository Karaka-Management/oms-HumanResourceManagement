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

use Modules\HumanResourceTimeRecording\Models\ClockingStatus;
use Modules\HumanResourceTimeRecording\Models\ClockingType;
use phpOMS\Stdlib\Base\SmartDateTime;
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
            <li><label for="c-tab-1"><?= $this->getHtml('General'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Clocking'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('Documents'); ?></label>
            <li><label for="c-tab-5"><?= $this->getHtml('Notes'); ?></label>
            <li><label for="c-tab-7"><?= $this->getHtml('Salary'); ?></label>
            <li><label for="c-tab-8"><?= $this->getHtml('Education'); ?></label>
            <li><label for="c-tab-9"><?= $this->getHtml('Work'); ?></label>
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
                            <span class="rf">
                                    <img class="m-profile rf"
                                        alt="<?= $this->getHtml('ProfileImage'); ?>"
                                        itemprop="logo" loading="lazy"
                                        src="<?=
                                            $employee->image->id === 0
                                                ? ($employee->profile->image->id === 0
                                                    ? UriFactory::build($this->getData('defaultImage')->getPath())
                                                    : UriFactory::build($employee->profile->image->getPath()))
                                                : UriFactory::build($employee->image->getPath()); ?>"
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
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet x-overflow">
                        <div class="portlet-head"><?= $this->getHtml('History'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <table id="historyList" class="default sticky">
                            <thead>
                                <td><?= $this->getHtml('Start'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('End'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('Unit'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('Department'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('Position'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
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
            <?php
                $busy = [
                    'total' => 0,
                    'month' => 0,
                    'week'  => 0,
                ];

                $type   = $this->data['lastSession'] !== null ? $this->data['lastSession']->type : ClockingType::OFFICE;
                $status = $this->data['lastSession'] !== null ? $this->data['lastSession']->getStatus() : ClockingStatus::END;

                $startMonth = new SmartDateTime('now');
                $startMonth = $startMonth->getStartOfMonth();
                $endMonth   = $startMonth->createModify(0, 1, -1);

                $startWeek = $endMonth->getStartOfWeek();
                $endWeek   = $startWeek->createModify(0, 0, 6);

                $current = $startMonth->createModify(0, 1);
                $end     = $endMonth->createModify(-1);
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Recordings', 'HumanResourceTimeRecording', 'Backend'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <div class="slider">
                        <table id="recordingList" class="default sticky">
                            <thead>
                            <tr>
                                <td><?= $this->getHtml('Date', 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <label for="recordingList-sort-1">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-1">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="recordingList-sort-2">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-2">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Type', 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <label for="recordingList-sort-3">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-3">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="recordingList-sort-4">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-4">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Status', 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <label for="recordingList-sort-5">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-5">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="recordingList-sort-6">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-6">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Start', 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <label for="recordingList-sort-7">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-7">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="recordingList-sort-8">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-8">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Break', 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <label for="recordingList-sort-9">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-9">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="recordingList-sort-10">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-10">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('End', 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <label for="recordingList-sort-11">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-11">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="recordingList-sort-12">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-12">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Total', 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <label for="recordingList-sort-13">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-13">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="recordingList-sort-14">
                                        <input type="radio" name="recordingList-sort" id="recordingList-sort-14">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                            <tbody>
                            <?php
                            $sessions = $this->data['sessions'];
                            $session  = empty($sessions)
                                ? new \Modules\HumanResourceTimeRecording\Models\NullSession()
                                : \reset($sessions);

                            while ($current->format('Y-m-d') !== $end->format('Y-m-d')) :
                                $current->smartModify(0, 0, -1);

                                if ($session->id !== 0 && $session->start->format('Y-m-d') === $current->format('Y-m-d')) :
                                    $url = UriFactory::build('{/base}/private/timerecording/session?{?}&id=' . $session->id);
                            ?>
                            <tr data-href="<?= $url; ?>">
                                <td><a href="<?= $url; ?>">
                                    <?php
                                        if ($this->data['lastSession'] !== null
                                            && $session->start->format('Y-m-d') === $this->data['lastSession']->start->format('Y-m-d')
                                        ) : ?>
                                        <span class="tag">Today</span>
                                    <?php else : ?>
                                        <?= $session->start->format('Y-m-d'); ?> - <?= $this->getHtml('D' . $session->start->format('w'), 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <?php endif; ?></a>
                                <td><a href="<?= $url; ?>"><span class="tag"><?= $this->getHtml('CT' . $session->type, 'HumanResourceTimeRecording', 'Backend'); ?></span></a>
                                <td><a href="<?= $url; ?>"><span class="tag"><?= $this->getHtml('CS' . $session->getStatus(), 'HumanResourceTimeRecording', 'Backend'); ?></span></a>
                                <td><a href="<?= $url; ?>"><?= $session->start->format('H:i'); ?></a>
                                <td><a href="<?= $url; ?>"><?= (int) ($session->getBreak() / 3600); ?>h <?= ((int) ($session->getBreak() / 60) % 60); ?>m</a>
                                <td><a href="<?= $url; ?>"><?= $session->end?->format('H:i'); ?></a>
                                <td><a href="<?= $url; ?>"><?= (int) ($session->getBusy() / 3600); ?>h <?= ((int) ($session->getBusy() / 60) % 60); ?>m</a>
                            <?php
                                $busy['week']  += $session->getBusy();
                                $busy['month'] += $session->getBusy();

                                $session = \next($sessions);
                                if ($session === false) {
                                    $session = new \Modules\HumanResourceTimeRecording\Models\NullSession();
                                }

                                // Required to handle multiple sessions in one day
                                if ($session->id !== 0 && $session->start->format('Y-m-d') === $current->format('Y-m-d')) {
                                    $current->smartModify(0, 0, 1);
                                }
                            ?>
                            <?php else : ?>
                            <tr>
                                <td class="disabled"><?= $current->format('Y-m-d'); ?> - <?= $this->getHtml('D' . $current->format('w'), 'HumanResourceTimeRecording', 'Backend'); ?>
                                <td colspan="6" class="empty">
                            <?php endif; ?>
                            <?php if ($current->getTimestamp() <= $startWeek->getTimestamp()) : ?>
                            <tr>
                                <th colspan="6" class="hl-3"> <?= $startWeek->format('Y/m/d'); ?> - <?= $endWeek->format('Y/m/d'); ?>
                                <th class="hl-3"><?= (int) ($busy['week'] / 3600); ?>h <?= ((int) ($busy['week'] / 60) % 60); ?>m
                            <?php
                                    $endWeek      = $startWeek->createModify(0, 0, -1);
                                    $startWeek    = $startWeek->createModify(0, 0, -7);
                                    $busy['week'] = 0;
                                endif;
                            ?>
                            <?php if ($current->getTimestamp() <= $startMonth->getTimestamp()) : ?>
                            <tr>
                                <th colspan="6" class="hl-2"><?= $startMonth->format('Y/m/d'); ?> - <?= $endMonth->format('Y/m/d'); ?>
                                <th class="hl-2"><?= (int) ($busy['month'] / 3600); ?>h <?= ((int) ($busy['month'] / 60) % 60); ?>m
                            <?php
                                    $endMonth      = $startMonth->createModify(0, 0, -1);
                                    $startMonth    = $startMonth->createModify(0, -1, 0);
                                    $busy['month'] = 0;
                                endif;
                            ?>
                            <?php endwhile; ?>
                        </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-3" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-3' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <?= $this->data['media-upload']->render('employee-file', 'files', '', $employee->files); ?>
        </div>

        <input type="radio" id="c-tab-5" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-5' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <?= $this->data['employee-notes']->render('employee-notes', '', $employee->notes); ?>
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
                        <div class="portlet-head"><?= $this->getHtml('Education'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <table id="historyList" class="default sticky">
                            <thead>
                                <td><?= $this->getHtml('Start'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('End'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('Title'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('Address'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
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
                        <div class="portlet-head"><?= $this->getHtml('Work'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <table id="historyList" class="default sticky">
                            <thead>
                                <td><?= $this->getHtml('Start'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('End'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('Title'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                <td><?= $this->getHtml('Address'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
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