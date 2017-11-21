<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');


$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit Session'), ['action' => 'edit', $session->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Session'), ['action' => 'delete', $session->id], ['confirm' => __('Are you sure you want to delete # {0}?', $session->id)]) ?> </li>
<li><?= $this->Html->link(__('List Sessions'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Session'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Speakers'), ['controller' => 'Speakers', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Speaker'), ['controller' => 'Speakers', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Vote Groups'), ['controller' => 'VoteGroups', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote Group'), ['controller' => 'VoteGroups', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit Session'), ['action' => 'edit', $session->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Session'), ['action' => 'delete', $session->id], ['confirm' => __('Are you sure you want to delete # {0}?', $session->id)]) ?> </li>
<li><?= $this->Html->link(__('List Sessions'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Session'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Speakers'), ['controller' => 'Speakers', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Speaker'), ['controller' => 'Speakers', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Vote Groups'), ['controller' => 'VoteGroups', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote Group'), ['controller' => 'VoteGroups', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($session->name) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Conference') ?></td>
            <td><?= $session->has('conference') ? $this->Html->link($session->conference->name, ['controller' => 'Conferences', 'action' => 'view', $session->conference->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Speaker') ?></td>
            <td><?= $session->has('speaker') ? $this->Html->link($session->speaker->name, ['controller' => 'Speakers', 'action' => 'view', $session->speaker->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Vote Group') ?></td>
            <td><?= $session->has('vote_group') ? $this->Html->link($session->vote_group->name, ['controller' => 'VoteGroups', 'action' => 'view', $session->vote_group->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Hash') ?></td>
            <td><?= h($session->hash) ?></td>
        </tr>
        <tr>
            <td><?= __('Name') ?></td>
            <td><?= h($session->name) ?></td>
        </tr>
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($session->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($session->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($session->modified) ?></td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Related Votes') ?></h3>
    </div>
    <?php if (!empty($session->votes)): ?>
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
            <?php foreach ($session->votes as $votes): ?>
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
