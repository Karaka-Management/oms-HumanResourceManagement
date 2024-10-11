<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\HumanResourceManagement\Models\EmployeeStatus;
use Modules\HumanResourceTimeRecording\Models\ClockingStatus;
use Modules\HumanResourceTimeRecording\Models\ClockingType;
use phpOMS\Stdlib\Base\SmartDateTime;
use phpOMS\Uri\UriFactory;

$employee      = $this->data['employee'];
$history       = $employee->getHistory();
$education     = $employee->getEducationHistory();
$work          = $employee->getWorkHistory();
$recentHistory = $employee->getNewestHistory();

$staffStatus = EmployeeStatus::getConstants();

echo $this->data['nav']->render(); ?>
<div class="tabview tab-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('General'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Address'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('Clocking'); ?></label>
            <li><label for="c-tab-4"><?= $this->getHtml('Documents'); ?></label>
            <li><label for="c-tab-5"><?= $this->getHtml('Notes'); ?></label>
            <!-- @todo Implement new module called Payroll
            <li><label for="c-tab-7"><?= $this->getHtml('Salary'); ?></label>
            -->
            <li><label for="c-tab-8"><?= $this->getHtml('Education'); ?></label>
            <li><label for="c-tab-9"><?= $this->getHtml('Work'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2"<?= empty($this->request->uri->fragment) || $this->request->uri->fragment === 'c-tab-1' ? ' checked' : ''; ?>>
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
                                                    ? UriFactory::build($this->data['defaultImage']->getPath())
                                                    : UriFactory::build($employee->profile->image->getPath()))
                                                : UriFactory::build($employee->image->getPath()); ?>"
                                    >
                                </span>
                                <div class="form-group">
                                    <label for="iStatus"><?= $this->getHtml('Status'); ?></label>
                                    <select id="iStatus" name="status">
                                        <?php foreach ($staffStatus as $status) : ?>
                                            <option value="<?= $status; ?>"<?= $employee->status === $status ? ' selected': ''; ?>><?= $this->getHtml(':status-' . $status); ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
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
                                            <td itemprop="birthDate"><?= $employee->profile->birthday?->format('Y-m-d'); ?>
                                        <tr>
                                            <th><?= $this->getHtml('Email'); ?>
                                            <td itemprop="email"><a href="mailto:<?= $this->printHtml($employee->profile->account->getEmail()); ?>"><?= $this->printHtml($employee->profile->account->getEmail()); ?></a>
                                        <tr>
                                            <th><?= $this->getHtml('Status'); ?>
                                            <td><span class="tag green"><?= $recentHistory->id > 0 ? $this->getHtml('Active') : $this->getHtml('Inactive'); ?></span>
                                    </table>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <form id="historyForm" action="<?= UriFactory::build('{/api}humanresource/staff/history'); ?>" method="post"
                            data-ui-container="#historyTable tbody"
                            data-add-form="historyForm"
                            data-add-tpl="#historyTable tbody .oms-add-tpl-history">
                            <div class="portlet-head"><?= $this->getHtml('History'); ?></div>
                            <div class="portlet-body">
                                <input type="hidden" id="iHistoryEmployee" name="employee" value="<?= $employee->id; ?>" disabled>

                                <div class="form-group">
                                    <label for="iHistoryId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                                    <input type="text" id="iHistoryId" name="id" data-tpl-text="/id" data-tpl-value="/id" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="iHistoryUnit"><?= $this->getHtml('Unit'); ?></label>
                                    <select id="iHistoryUnit" name="unit" data-tpl-text="/unit" data-tpl-value="/unit">
                                        <option value="">
                                        <?php
                                        foreach ($this->data['units'] as $unit) : ?>
                                            <option value="<?= $unit->id; ?>"><?= $this->printHtml($unit->name); ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="iHistoryDepartment"><?= $this->getHtml('Department'); ?></label>
                                    <select id="iHistoryDepartment" name="department" data-tpl-text="/department" data-tpl-value="/department">
                                        <option value="">
                                        <?php
                                        foreach ($this->data['departments'] as $department) : ?>
                                            <option value="<?= $department->id; ?>"><?= $this->printHtml($department->name); ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="iHistoryPosition"><?= $this->getHtml('Position'); ?></label>
                                    <select id="iHistoryPosition" name="position" data-tpl-text="/position" data-tpl-value="/position">
                                        <option value="">
                                        <?php
                                        foreach ($this->data['positions'] as $position) : ?>
                                            <option value="<?= $position->id; ?>"><?= $this->printHtml($position->name); ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="flex-line">
                                    <div>
                                        <div class="form-group">
                                            <label for="iHistoryStart"><?= $this->getHtml('Start'); ?></label>
                                            <input id="iHistoryStart" name="start" type="date" data-tpl-text="/start" data-tpl-value="/start">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="iHistoryEnd"><?= $this->getHtml('End'); ?></label>
                                            <input id="iHistoryEnd" name="end" type="date" data-tpl-text="/end" data-tpl-value="/end">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="portlet-foot">
                                <input id="bHistoryAdd" formmethod="put" type="submit" class="add-form" value="<?= $this->getHtml('Add', '0', '0'); ?>">
                                <input id="bHistorySave" formmethod="post" type="submit" class="save-form vh button save" value="<?= $this->getHtml('Update', '0', '0'); ?>">
                                <input id="bHistoryCancel" type="submit" class="cancel-form vh button close" value="<?= $this->getHtml('Cancel', '0', '0'); ?>">
                            </div>
                        </form>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('History'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <div class="slider">
                        <table id="historyTable" class="default sticky"
                            data-tag="form"
                            data-ui-element="tr"
                            data-add-tpl=".oms-add-tpl-history"
                            data-update-form="historyForm">
                            <thead>
                                <tr>
                                    <td>
                                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                                    <td><?= $this->getHtml('Start'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('End'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Unit'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Department'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Position'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                            <tbody>
                                <template class="oms-add-tpl-history">
                                    <tr class="animated medium-duration greenCircleFade" data-id="" draggable="false">
                                        <td>
                                            <i class="g-icon btn update-form">settings</i>
                                            <input id="historyTable-remove-0" type="checkbox" class="vh">
                                            <label for="historyTable-remove-0" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                            <span class="checked-visibility">
                                                <label for="historyTable-remove-0" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                                <label for="historyTable-remove-0" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                            </span>
                                        <td data-tpl-text="/id" data-tpl-value="/id"></td>
                                        <td data-tpl-text="/start" data-tpl-value="/start"></td>
                                        <td data-tpl-text="/end" data-tpl-value="/end"></td>
                                        <td data-tpl-text="/unit" data-tpl-value="/unit" data-value=""></td>
                                        <td data-tpl-text="/department" data-tpl-value="/department" data-value=""></td>
                                        <td data-tpl-text="/position" data-tpl-value="/position" data-value=""></td>
                                    </tr>
                                </template>
                                <?php $c = 0;
                                foreach ($history as $key => $value) : ++$c; ?>
                                    <tr data-id="<?= $value->id; ?>">
                                        <td>
                                            <i class="g-icon btn update-form">settings</i>
                                            <input id="historyTable-remove-<?= $value->id; ?>" type="checkbox" class="vh">
                                            <label for="historyTable-remove-<?= $value->id; ?>" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                            <span class="checked-visibility">
                                                <label for="historyTable-remove-<?= $value->id; ?>" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                                <label for="historyTable-remove-<?= $value->id; ?>" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                            </span>
                                        <td data-tpl-text="/id" data-tpl-value="/id"><?= $value->id; ?>
                                        <td data-tpl-text="/start" data-tpl-value="/start" data-value="<?= $value->start->format('Y-m-d'); ?>"><?= $value->start->format('Y-m-d'); ?>
                                        <td data-tpl-text="/end" data-tpl-value="/end" data-value="<?= $value->end?->format('Y-m-d'); ?>"><?= $value->end === null ? '' : $value->end->format('Y-m-d'); ?>
                                        <td data-tpl-text="/unit" data-tpl-value="/unit" data-value="<?= $value->unit->id; ?>"><?= $this->printHtml($value->unit->name); ?>
                                        <td data-tpl-text="/department" data-tpl-value="/department" data-value="<?= $value->department->id; ?>"><?= $this->printHtml($value->department->name); ?>
                                        <td data-tpl-text="/position" data-tpl-value="/position" data-value="<?= $value->position->id; ?>"><?= $this->printHtml($value->position->name); ?>
                                <?php endforeach; ?>
                                <?php if ($c === 0) : ?>
                                <tr>
                                    <td colspan="6" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                                <?php endif; ?>
                        </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-2" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-2' ? ' checked' : ''; ?>>
        <div class="tab">
            <?= $this->data['contact-component']->render('employee-contact', 'contacts', $employee->profile->account->contacts); ?>
            <?= $this->data['address-component']->render('employee-address', 'addresses', $employee->profile->account->addresses); ?>
        </div>

        <input type="radio" id="c-tab-3" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-3' ? ' checked' : ''; ?>>
        <div class="tab">
            <?php
                $busy = [
                    'total' => 0,
                    'month' => 0,
                    'week'  => 0,
                ];

                //$type   = $this->data['lastSession'] !== null ? $this->data['lastSession']->type : ClockingType::OFFICE;
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
                                        <?= $session->start->format('Y-m-d'); ?> - <?= $this->getHtml(':D' . $session->start->format('w'), 'HumanResourceTimeRecording', 'Backend'); ?>
                                    <?php endif; ?></a>
                                <td><a href="<?= $url; ?>"><span class="tag"><?= $this->getHtml(':CT' . $session->type, 'HumanResourceTimeRecording', 'Backend'); ?></span></a>
                                <td><a href="<?= $url; ?>"><span class="tag"><?= $this->getHtml(':CS' . $session->getStatus(), 'HumanResourceTimeRecording', 'Backend'); ?></span></a>
                                <td><a href="<?= $url; ?>"><?= $session->start->format('H:i'); ?></a>
                                <td><a href="<?= $url; ?>"><?= (int) ($session->getBreak() / 3600); ?>h <?= ((int) ($session->getBreak() / 60) % 60); ?>m</a>
                                <td><a href="<?= $url; ?>"><?= $session->end?->format('H:i'); ?></a>
                                <td><a href="<?= $url; ?>"><?= (int) ($session->busy / 3600); ?>h <?= ((int) ($session->busy / 60) % 60); ?>m</a>
                            <?php
                                $busy['week']  += $session->busy;
                                $busy['month'] += $session->busy;

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
                                <td class="disabled"><?= $current->format('Y-m-d'); ?> - <?= $this->getHtml(':D' . $current->format('w'), 'HumanResourceTimeRecording', 'Backend'); ?>
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

        <input type="radio" id="c-tab-4" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-4' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <?= $this->data['media-upload']->render('employee-file', 'files', '', $employee->files, '{/api}humanresource/staff/file?csrf={$CSRF}', (string) $vehicle->id); ?>
        </div>

        <input type="radio" id="c-tab-5" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-5' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <?= $this->data['employee-notes']->render('employee-notes', '', $employee->notes, '{/api}humanresource/staff/note?csrf={$CSRF}', (string) $vehicle->id); ?>
        </div>

        <input type="radio" id="c-tab-7" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-7' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
            </div>
        </div>

        <input type="radio" id="c-tab-8" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-7' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <form id="educationForm" action="<?= UriFactory::build('{/api}humanresource/staff/education'); ?>" method="post"
                            data-ui-container="#educationTable tbody"
                            data-add-form="educationForm"
                            data-add-tpl="#educationTable tbody .oms-add-tpl-education">
                            <div class="portlet-head"><?= $this->getHtml('Education'); ?></div>
                            <div class="portlet-body">
                                <input type="hidden" id="iEducationEmployee" name="employee" value="<?= $employee->id; ?>" disabled>

                                <div class="form-group">
                                    <label for="iEducationId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                                    <input type="text" id="iEducationId" name="id" data-tpl-text="/id" data-tpl-value="/id" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="iEducationTitle"><?= $this->getHtml('Title'); ?></label>
                                    <input type="text" id="iEducationTitle" name="title" data-tpl-text="/title" data-tpl-value="/title">
                                </div>

                                <div class="form-group">
                                    <label for="iEducationAddress"><?= $this->getHtml('Address'); ?></label>
                                    <input type="text" id="iEducationAddress" name="address" data-tpl-text="/address" data-tpl-value="/address">
                                </div>

                                <div class="form-group">
                                    <label for="iEducationScore"><?= $this->getHtml('Score'); ?></label>
                                    <input type="text" id="iEducationScore" name="score" data-tpl-text="/score" data-tpl-value="/score">
                                </div>

                                <div class="flex-line">
                                    <div>
                                        <div class="form-group">
                                            <label for="iEducationStart"><?= $this->getHtml('Start'); ?></label>
                                            <input id="iEducationStart" name="start" type="date" data-tpl-text="/start" data-tpl-value="/start">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="iEducationEnd"><?= $this->getHtml('End'); ?></label>
                                            <input id="iEducationEnd" name="end" type="date" data-tpl-text="/end" data-tpl-value="/end">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="portlet-foot">
                                <input id="bEducationAdd" formmethod="put" type="submit" class="add-form" value="<?= $this->getHtml('Add', '0', '0'); ?>">
                                <input id="bEducationSave" formmethod="post" type="submit" class="save-form vh button save" value="<?= $this->getHtml('Update', '0', '0'); ?>">
                                <input id="bEducationCancel" type="submit" class="cancel-form vh button close" value="<?= $this->getHtml('Cancel', '0', '0'); ?>">
                            </div>
                        </form>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Education'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <div class="slider">
                        <table id="educationTable" class="default sticky"
                            data-tag="form"
                            data-ui-element="tr"
                            data-add-tpl=".oms-add-tpl-education"
                            data-update-form="educationForm">
                            <thead>
                                <tr>
                                    <td>
                                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                                    <td><?= $this->getHtml('Start'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('End'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Title'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Address'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Score'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                            <tbody>
                                <template class="oms-add-tpl-education">
                                    <tr class="animated medium-duration greenCircleFade" data-id="" draggable="false">
                                        <td>
                                            <i class="g-icon btn update-form">settings</i>
                                            <input id="educationTable-remove-0" type="checkbox" class="vh">
                                            <label for="educationTable-remove-0" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                            <span class="checked-visibility">
                                                <label for="educationTable-remove-0" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                                <label for="educationTable-remove-0" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                            </span>
                                        <td data-tpl-text="/id" data-tpl-value="/id"></td>
                                        <td data-tpl-text="/start" data-tpl-value="/start"></td>
                                        <td data-tpl-text="/end" data-tpl-value="/end"></td>
                                        <td data-tpl-text="/title" data-tpl-value="/title"></td>
                                        <td data-tpl-text="/address" data-tpl-value="/address"></td>
                                        <td data-tpl-text="/score" data-tpl-value="/score"></td>
                                    </tr>
                                </template>
                                <?php $c = 0;
                                foreach ($education as $key => $value) : ++$c; ?>
                                    <tr data-id="<?= $value->id; ?>">
                                        <td>
                                            <i class="g-icon btn update-form">settings</i>
                                            <input id="educationTable-remove-<?= $value->id; ?>" type="checkbox" class="vh">
                                            <label for="educationTable-remove-<?= $value->id; ?>" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                            <span class="checked-visibility">
                                                <label for="educationTable-remove-<?= $value->id; ?>" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                                <label for="educationTable-remove-<?= $value->id; ?>" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                            </span>
                                        <td data-tpl-text="/id" data-tpl-value="/id"><?= $value->id; ?>
                                        <td data-tpl-text="/start" data-tpl-value="/start" data-value="<?= $value->start->format('Y-m-d'); ?>"><?= $value->start->format('Y-m-d'); ?>
                                        <td data-tpl-text="/end" data-tpl-value="/end" data-value="<?= $value->end?->format('Y-m-d'); ?>"><?= $value->end === null ? '' : $value->end->format('Y-m-d'); ?>
                                        <td data-tpl-text="/title" data-tpl-value="/title"><?= $this->printHtml($value->educationTitle); ?>
                                        <td data-tpl-text="/address" data-tpl-value="/address"><?= $this->printHtml($value->address->name); ?>
                                        <td data-tpl-text="/score" data-tpl-value="/score"><?= $this->printHtml($value->score); ?>
                                <?php endforeach; ?>
                                <?php if ($c === 0) : ?>
                                <tr>
                                    <td colspan="6" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                                <?php endif; ?>
                        </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-9" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-8' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <form id="workForm" action="<?= UriFactory::build('{/api}humanresource/staff/work'); ?>" method="post"
                            data-ui-container="#workTable tbody"
                            data-add-form="workForm"
                            data-add-tpl="#workTable tbody .oms-add-tpl-work">
                            <div class="portlet-head"><?= $this->getHtml('Work'); ?></div>
                            <div class="portlet-body">
                                <input type="hidden" id="iWorkEmployee" name="employee" value="<?= $employee->id; ?>" disabled>

                                <div class="form-group">
                                    <label for="iWorkId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                                    <input type="text" id="iWorkId" name="id" data-tpl-text="/id" data-tpl-value="/id" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="iWorkTitle"><?= $this->getHtml('Title'); ?></label>
                                    <input type="text" id="iWorkTitle" name="title" data-tpl-text="/title" data-tpl-value="/title">
                                </div>

                                <div class="form-group">
                                    <label for="iWorkAddress"><?= $this->getHtml('Address'); ?></label>
                                    <input type="text" id="iWorkAddress" name="address" data-tpl-text="/address" data-tpl-value="/address">
                                </div>

                                <div class="flex-line">
                                    <div>
                                        <div class="form-group">
                                            <label for="iWorkStart"><?= $this->getHtml('Start'); ?></label>
                                            <input id="iWorkStart" name="start" type="date" data-tpl-text="/start" data-tpl-value="/start">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="iWorkEnd"><?= $this->getHtml('End'); ?></label>
                                            <input id="iWorkEnd" name="end" type="date" data-tpl-text="/end" data-tpl-value="/end">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="portlet-foot">
                                <input id="bWorkAdd" formmethod="put" type="submit" class="add-form" value="<?= $this->getHtml('Add', '0', '0'); ?>">
                                <input id="bWorkSave" formmethod="post" type="submit" class="save-form vh button save" value="<?= $this->getHtml('Update', '0', '0'); ?>">
                                <input id="bWorkCancel" type="submit" class="cancel-form vh button close" value="<?= $this->getHtml('Cancel', '0', '0'); ?>">
                            </div>
                        </form>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Work'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <div class="slider">
                        <table id="workTable" class="default sticky"
                            data-tag="form"
                            data-ui-element="tr"
                            data-add-tpl=".oms-add-tpl-work"
                            data-update-form="workForm">
                            <thead>
                                <tr>
                                    <td>
                                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                                    <td><?= $this->getHtml('Start'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('End'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Title'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                                    <td><?= $this->getHtml('Address'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                            <tbody>
                                <template class="oms-add-tpl-work">
                                    <tr class="animated medium-duration greenCircleFade" data-id="" draggable="false">
                                        <td>
                                            <i class="g-icon btn update-form">settings</i>
                                            <input id="workTable-remove-0" type="checkbox" class="vh">
                                            <label for="workTable-remove-0" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                            <span class="checked-visibility">
                                                <label for="workTable-remove-0" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                                <label for="workTable-remove-0" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                            </span>
                                        <td data-tpl-text="/id" data-tpl-value="/id"></td>
                                        <td data-tpl-text="/start" data-tpl-value="/start"></td>
                                        <td data-tpl-text="/end" data-tpl-value="/end"></td>
                                        <td data-tpl-text="/title" data-tpl-value="/title"></td>
                                        <td data-tpl-text="/address" data-tpl-value="/address"></td>
                                    </tr>
                                </template>
                                <?php $c = 0;
                                foreach ($work as $key => $value) : ++$c; ?>
                                    <tr data-id="<?= $value->id; ?>">
                                        <td>
                                            <i class="g-icon btn update-form">settings</i>
                                            <input id="workTable-remove-<?= $value->id; ?>" type="checkbox" class="vh">
                                            <label for="workTable-remove-<?= $value->id; ?>" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                            <span class="checked-visibility">
                                                <label for="workTable-remove-<?= $value->id; ?>" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                                <label for="workTable-remove-<?= $value->id; ?>" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                            </span>
                                        <td data-tpl-text="/id" data-tpl-value="/id"><?= $value->id; ?>
                                        <td data-tpl-text="/start" data-tpl-value="/start" data-value="<?= $value->start->format('Y-m-d'); ?>"><?= $value->start->format('Y-m-d'); ?>
                                        <td data-tpl-text="/end" data-tpl-value="/end" data-value="<?= $value->end?->format('Y-m-d'); ?>"><?= $value->end === null ? '' : $value->end->format('Y-m-d'); ?>
                                        <td data-tpl-text="/title" data-tpl-value="/title"><?= $this->printHtml($value->jobTitle); ?>
                                        <td data-tpl-text="/address" data-tpl-value="/address"><?= $this->printHtml($value->address->name); ?>
                                <?php endforeach; ?>
                                <?php if ($c === 0) : ?>
                                <tr>
                                    <td colspan="6" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                                <?php endif; ?>
                        </table>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
</div>