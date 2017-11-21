<?php
/* @var $this \Cake\View\View */
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>
<?php $this->start('tb_actions'); ?>
<li>
    <?= $this->Html->link(
        __('Flush QRs'),
        ['controller' => 'Dashboard', 'action' => 'flushQrs', 'conference' => $conference->slug],
        ['confirm' => __('Delete all QR images.')]
    ); ?>
</li>
<li>
    <?= $this->Html->link(
        __('Flush Avatars'),
        ['controller' => 'Dashboard', 'action' => 'flushAvatars', 'conference' => $conference->slug],
        ['confirm' => __('Delete all avatars.')]
    ); ?>
</li>

<li><?= $this->Html->link(__('Fetch QRs'), ['controller' => 'Dashboard', 'action' => 'fetchQrs', 'conference' => $conference->slug]); ?></li>
<li><?= $this->Html->link(__('Fetch Avatars'), ['controller' => 'Dashboard', 'action' => 'fetchAvatars', 'conference' => $conference->slug]); ?></li>

<li><?= $this->Html->link(__('Import Sessions'), ['controller' => 'Dashboard', 'action' => 'importSessions', 'conference' => $conference->slug]); ?></li>

<li><?= $this->Html->link(__('Download Users'), ['controller' => 'Dashboard', 'action' => 'downloadCsv', 'conference' => $conference->slug]); ?></li>

<?php if ($extraAction){ foreach ($extraAction->actions as $action){ ?>
    <li><?= $this->Html->link($action['title'], ['controller' => 'Dashboard', 'action' => 'extraAction', 'conference' => $conference->slug, $action['method']]) ?></li>
<?php }} ?>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<?= $this->start('script'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    <?php /*
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Density", { role: "style" } ],
            ["Copper", 8.94, "color: #e5e4e2"],
            ["Silver", 10.49, "color: #e5e4e2"],
            ["Gold", 19.30, "color: #e5e4e2"],
            ["Platinum", 21.45, "color: #e5e4e2"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            { calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation" },
            2]);

        var options = {
            title: "Density of Precious Metals, in g/cm^3",
            width: 600,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("chart"));
        chart.draw(view, options);
    }
    */ ?>

    $(function(){
        var dndZone = $('#dnd-zone');
        var fileField = $('#file-field');

        dndZone.on('dragover', function(e){
            e.preventDefault();
            dndZone.addClass('dragover');
        });
        dndZone.on('dragleave', function(e){
            e.preventDefault();
            dndZone.removeClass('dragover');
        });

        dndZone.on('drop', function(e){
            e.preventDefault();
            dndZone.removeClass('dragover');
            fileField.prop('files', e.originalEvent.dataTransfer.files);
        });
    });
</script>
<?= $this->end(); ?>
<?php $this->start('css'); ?>
<style>
    p.bg-info { padding:15px; margin:20px 0; }
    #dnd-zone {
        margin:10px 0 20px 0;
        background-color:#f0f0f0;
        padding:15px;
        width:300px;

        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
    }
    div.section-block-inner {
        margin:10px 0 20px 0;
        background-color:#f0f0f0;
        padding:15px;

        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
    }
    #dnd-zone hr {
        border-color:#c0c0c0;
    }

    .dragover {
        background-color:#f48fb1 !important;
    }

    div.section {}
    div.section:after {
        content: ".";
        display: block;
        height: 0;
        font-size: 0;
        clear: both;
        visibility:hidden;
    }

    #data-tab {
        margin-bottom:30px;
    }

    div.section-block {
        float:left;
        margin-bottom:10px;
        margin-right:10px;
    }

    tr.inactive td {
        background-color:#f0f0f0;
    }
    td.sns-avatar img {
        width:20px;
    }
    td.qr img {
        width:20px;
    }

    h3.feedback { font-size: 10pt; font-weight:bolder; }
    table.feedback {}
    table.feedback td, table.feedback th {
        padding:5px 10px;
    }

    #vote-group-selector {
        margin-bottom:30px;
    }
</style>
<?php $this->end(); ?>

<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Home'), ['controller' => 'Admins', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link($conference->name, ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug]); ?></li>
</ol>

<div class="section">
    <div class="section-block">
        <h2><?= __('Statistics'); ?></h2>

        <ul class="dashboard">
            <li>
                <div class="title"><?= __('Users') ?></div>
                <div class="count"><?= $users->count() ?></div>
            </li>
            <li>
                <div class="title"><?= __('Avatars') ?></div>
                <div class="count"><?= $count_avatars ?></div>
            </li>
            <li>
                <div class="title"><?= __('QRs') ?></div>
                <div class="count"><?= $count_qrs ?></div>
            </li>
        </ul>
    </div>

    <div class="section-block">
        <h2><?= __('Import CSV'); ?></h2>

        <?= $this->Form->create($importPeatix, ["type" => "file"]); ?>
        <div id="dnd-zone">
            <p><?= __('Drop one or more files to import.') ?></p>
            <?= $this->Form->control('files[]', ['type' => 'file', 'id' => 'file-field', 'label' => false, 'required', 'multiple']); ?>
            <hr />
            <?= $this->Form->submit(__('Submit'), ['class' => ['btn', 'btn-primary']]); ?>
        </div>
        <?= $this->Form->end(); ?>
    </div>

    <div class="section-block">
        <h2><?= __('Create User'); ?></h2>

        <div class="section-block-inner">
            <?= $this->Form->create(null, ['url' => ['action' => 'create_user', 'conference' => $conference->slug]]); ?>
            <?= $this->Form->text('ticketType', ['style' => 'width:80px;', 'placeholder' => 'Ticket']); ?>
            <?= $this->Form->text('numberFrom', ['style' => 'width:60px;', 'placeholder' => 'From']); ?>
            <?= $this->Form->text('numberTo', ['style' => 'width:60px;', 'placeholder' => 'To']); ?>
            <?= $this->Form->hidden('action', ['value' => 'create-user']); ?>
            <?= $this->Form->submit(__('Create'), ['class' => ['btn', 'btn-primary'], 'style' => 'margin-top:10px;']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <div class="section-block">
        <h2><?= __('Feedback Request Email'); ?></h2>

        <div class="section-block-inner">
            <?= $this->Form->create(null, ['url' => ['action' => 'send_feedback_email_all', 'conference' => $conference->slug]]); ?>
            <?= $this->Form->submit(__('Send to all'), ['class' => ['btn', 'btn-danger']]); ?>
            <?= $this->Form->hidden('action', ['value' => 'send-emails']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <div class="section-block">
        <h2><?= __('Feedback Report Email'); ?></h2>

        <div class="section-block-inner">
            <?= $this->Form->create(null, ['url' => ['action' => 'send_feedback_report_email_all', 'conference' => $conference->slug]]); ?>
            <?= $this->Form->submit(__('Send to all'), ['class' => ['btn', 'btn-danger']]); ?>
            <?= $this->Form->hidden('action', ['value' => 'send-emails']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <div class="section-block">
        <div id="chart"></div>
    </div>
</div>

<?php if (isset($results)){ ?>
<div class="section">
    <div class="alert alert-success">
        <?php if (count($results['added']) > 0){ ?>
            <p><?= $results['added'] ?> record<?= $results['added'] > 1? 's': '' ?> added.</p>
        <?php } ?>
        <?php if (count($results['updated']) > 0){ ?>
            <p><?= $results['updated'] ?> record<?= $results['updated'] > 1? 's': '' ?> updated.</p>
        <?php } ?>
        <?php if (count($results['skipped']) > 0){ ?>
            <p><?= $results['skipped'] ?> record<?= $results['skipped'] > 1? 's': '' ?> skipped.</p>
        <?php } ?>
    </div>
    <?php if (count($results['errors']) > 0){ ?>
        <div class="alert alert-danger">
            <?php foreach ($results['errors'] as $file => $errors){ ?>
                <p><em><?= $file ?></em></p>
                <?php foreach ($errors as $error){ ?>
                    <p><?= __('Line {0}: {1}', $error['line'], $error['error']) ?></p>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php } ?>

<ul class="nav nav-tabs" id="data-tab">
    <li role="presentation"<?php if ($tab == 'users'){ ?> class="active"<?php } ?>>
        <?= $this->Html->link(
            __('Users'),
            ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug, 'users']
        ); ?>
    </li>
    <li role="presentation"<?php if ($tab == 'sessions'){ ?> class="active"<?php } ?>>
        <?= $this->Html->link(
            __('Sessions'),
            ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug, 'sessions']
        ); ?>
    </li>
    <li role="presentation"<?php if ($tab == 'feedbacks'){ ?> class="active"<?php } ?>>
        <?= $this->Html->link(
            __('Feedbacks'),
            ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug, 'feedbacks']
        ); ?>
    </li>
</ul>

<?php if ($tab == 'users'){ ?>
<div class="section">
    <?php if ($users->count() > 0){ ?>
    <table class="table" id="users">
        <tr>
            <th><?= __('Ticket Type'); ?></th>
            <th><?= __('Ticket No.'); ?></th>
            <th><?= __('Name'); ?></th>
            <th><?= __('Vote page view'); ?></th>
            <th><?= __('SNS'); ?></th>
            <th><?= __('Avatar'); ?></th>
            <th><?= __('QR'); ?></th>
        </tr>
        <?php foreach ($users as $user){ ?>
            <?php /** @var \App\Model\Entity\User $user */ ?>
            <tr<?php if ($user->vote_page_view == 0){ ?> class="inactive"<?php } ?>>
                <td><?= $user->ticket_type ?></td>
                <td><?= $user->ticket_no ?></td>
                <td><?= $this->Html->link($user->name, ['controller' => 'Dashboard', 'action' => 'user', 'conference' => $conference->slug, $user->hash]) ?></td>
                <td><?= $user->vote_page_view ?></td>
                <td>
                    <?php
                    if ($sns = $user->activeSns()){
                        if ($link = $user->activeSnsLink()){
                            echo $this->Html->link($sns." / ".$user->activeSnsAccount(), $link, ['target' => '_blank']);
                        } else {
                            echo $sns." / ".$user->activeSnsAccount();
                        }
                    }
                    ?>
                </td>
                <td class="sns-avatar">
                    <?php
                    if ($user->avatar_icon_filename){
                        echo $this->Html->image(
                            '/files/'.$conference->slug.'/avatar/'.urlencode($user->avatar_icon_filename)
                        );
                    }
                    ?>
                </td>
                <td class="qr">
                    <?php
                    if ($user->qr_filename){
                        echo $this->Html->image(
                            '/files/'.$conference->slug.'/qr/'.urlencode($user->qr_filename)
                        );
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
        <div class="alert alert-info"><?= __('No users. Import CSV to add user.'); ?></div>
    <?php } ?>
</div>
<?php } ?>

<?php if ($tab == 'sessions'){ ?>
    <ul class="nav nav-pills" id="vote-group-selector">
        <li role="presentation"<?php if (! isset($activeVoteGroup)){ ?> class="active"<?php } ?>>
            <?= $this->Html->link('すべて', ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug, 'sessions']); ?>
        </li>
        <?php foreach ($voteGroups as $voteGroup){ ?>
        <li role="presentation"<?php if (isset($activeVoteGroup) and $activeVoteGroup->id == $voteGroup->id){ ?> class="active"<?php } ?>>
            <?= $this->Html->link($voteGroup->name, ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug, 'sessions', '?' => ['group' => $voteGroup->slug]]); ?>
        </li>
        <?php } ?>
    </ul>
    <?php if ($sessions->count() > 0){ ?>
        <table class="table" id="sessions">
            <tr>
                <th><?= __('Start'); ?></th>
                <th><?= __('Track'); ?></th>
                <th><?= __('Speaker'); ?></th>
                <th><?= __('Title'); ?></th>
                <th><?= __('Feedback Report'); ?></th>
                <th><?= __('Number of votes'); ?></th>
            </tr>
            <?php foreach ($sessions as $session){ ?>
                <tr<?php if ($session->number_of_votes > 0){ ?> class="danger"<?php } ?>>
                    <td><?= $session->start_at->i18nFormat('yyyy/MM/dd HH:mm') ?></td>
                    <td><?= $session->track->name ?></td>
                    <td><?= $session->speaker->name ?></td>
                    <td><?= $session->title ?></td>
                    <td><?= $this->Html->link(__('Send'), ['action' => 'sendFeedbackReportEmail', 'conference' => $conference->slug, '?' => ['session' => $session->hash]], ['class' => ['btn btn-danger']]); ?></td>
                    <td><?= $session->number_of_votes ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="alert alert-info"><?= __('No sessions.'); ?></div>
    <?php } ?>
<?php } ?>

<?php if ($tab == 'feedbacks'){ ?>
    <ul>
    <?php foreach ($feedbackQuestions as $feedbackQuestion){ ?>
        <li>Q<?= $feedbackQuestion->question_no ?>: <?= $feedbackQuestion->question ?></li>
    <?php } ?>
    </ul>

    <?php foreach ($feedbackResults as $feedbackResult){ ?>
        <h3 class="feedback"><?= $feedbackResult['session']->title ?></h3>
        <table class="feedback">
            <tr>
                <th>id</th>
                <th>created</th>
                <?php foreach ($feedbackQuestions as $feedbackQuestion){ ?>
                    <th>Q<?= $feedbackQuestion->question_no ?></th>
                <?php } ?>
            </tr>
        <?php foreach ($feedbackResult['answers'] as $answers){ ?>
            <tr>
                <td><?= $answers['feedback']->id ?></td>
                <td><?= $answers['feedback']->created ?></td>
                <?php foreach ($answers['answers'] as $answer){?>
                    <td><?= $answer->answer ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </table>
    <?php } ?>
<?php } ?>

