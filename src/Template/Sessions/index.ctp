<?php
/* @var $this \Cake\View\View */
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('New Session'), ['action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List Speakers'), ['controller' => 'Speakers', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Speaker'), ['controller' => 'Speakers', 'action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List VoteGroups'), ['controller' => 'VoteGroups', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Vote Group'), ['controller' => 'VoteGroups', 'action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']); ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id'); ?></th>
            <th><?= $this->Paginator->sort('conference_id'); ?></th>
            <th><?= $this->Paginator->sort('speaker_id'); ?></th>
            <th><?= $this->Paginator->sort('vote_group_id'); ?></th>
            <th><?= $this->Paginator->sort('hash'); ?></th>
            <th><?= $this->Paginator->sort('name'); ?></th>
            <th><?= $this->Paginator->sort('created'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sessions as $session): ?>
        <tr>
            <td><?= $this->Number->format($session->id) ?></td>
            <td>
                <?= $session->has('conference') ? $this->Html->link($session->conference->name, ['controller' => 'Conferences', 'action' => 'view', $session->conference->id]) : '' ?>
            </td>
            <td>
                <?= $session->has('speaker') ? $this->Html->link($session->speaker->name, ['controller' => 'Speakers', 'action' => 'view', $session->speaker->id]) : '' ?>
            </td>
            <td>
                <?= $session->has('vote_group') ? $this->Html->link($session->vote_group->name, ['controller' => 'VoteGroups', 'action' => 'view', $session->vote_group->id]) : '' ?>
            </td>
            <td><?= h($session->hash) ?></td>
            <td><?= h($session->name) ?></td>
            <td><?= h($session->created) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $session->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $session->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $session->id], ['confirm' => __('Are you sure you want to delete # {0}?', $session->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>
