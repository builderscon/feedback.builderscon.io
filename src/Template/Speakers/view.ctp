<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');


$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit Speaker'), ['action' => 'edit', $speaker->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Speaker'), ['action' => 'delete', $speaker->id], ['confirm' => __('Are you sure you want to delete # {0}?', $speaker->id)]) ?> </li>
<li><?= $this->Html->link(__('List Speakers'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Speaker'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit Speaker'), ['action' => 'edit', $speaker->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Speaker'), ['action' => 'delete', $speaker->id], ['confirm' => __('Are you sure you want to delete # {0}?', $speaker->id)]) ?> </li>
<li><?= $this->Html->link(__('List Speakers'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Speaker'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($speaker->name) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Name') ?></td>
            <td><?= h($speaker->name) ?></td>
        </tr>
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($speaker->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($speaker->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($speaker->modified) ?></td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Related Sessions') ?></h3>
    </div>
    <?php if (!empty($speaker->sessions)): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Conference Id') ?></th>
                <th><?= __('Speaker Id') ?></th>
                <th><?= __('Vote Group Id') ?></th>
                <th><?= __('Hash') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($speaker->sessions as $sessions): ?>
                <tr>
                    <td><?= h($sessions->id) ?></td>
                    <td><?= h($sessions->conference_id) ?></td>
                    <td><?= h($sessions->speaker_id) ?></td>
                    <td><?= h($sessions->vote_group_id) ?></td>
                    <td><?= h($sessions->hash) ?></td>
                    <td><?= h($sessions->name) ?></td>
                    <td><?= h($sessions->created) ?></td>
                    <td><?= h($sessions->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('', ['controller' => 'Sessions', 'action' => 'view', $sessions->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                        <?= $this->Html->link('', ['controller' => 'Sessions', 'action' => 'edit', $sessions->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                        <?= $this->Form->postLink('', ['controller' => 'Sessions', 'action' => 'delete', $sessions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sessions->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="panel-body">no related Sessions</p>
    <?php endif; ?>
</div>
