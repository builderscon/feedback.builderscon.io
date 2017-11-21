<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');


$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
<li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
<li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($user->id) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Email') ?></td>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <td><?= __('Password') ?></td>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <td><?= __('Conference') ?></td>
            <td><?= $user->has('conference') ? $this->Html->link($user->conference->name, ['controller' => 'Conferences', 'action' => 'view', $user->conference->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Hash') ?></td>
            <td><?= h($user->hash) ?></td>
        </tr>
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <td><?= __('Ticket No') ?></td>
            <td><?= $this->Text->autoParagraph(h($user->ticket_no)); ?></td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Related Votes') ?></h3>
    </div>
    <?php if (!empty($user->votes)): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Session Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($user->votes as $votes): ?>
                <tr>
                    <td><?= h($votes->id) ?></td>
                    <td><?= h($votes->session_id) ?></td>
                    <td><?= h($votes->user_id) ?></td>
                    <td><?= h($votes->created) ?></td>
                    <td><?= h($votes->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('', ['controller' => 'Votes', 'action' => 'view', $votes->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                        <?= $this->Html->link('', ['controller' => 'Votes', 'action' => 'edit', $votes->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                        <?= $this->Form->postLink('', ['controller' => 'Votes', 'action' => 'delete', $votes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $votes->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="panel-body">no related Votes</p>
    <?php endif; ?>
</div>
