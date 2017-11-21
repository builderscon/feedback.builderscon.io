<?php
/* @var $this \Cake\View\View */
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('New Vote Group'), ['action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']); ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id'); ?></th>
            <th><?= $this->Paginator->sort('conference_id'); ?></th>
            <th><?= $this->Paginator->sort('name'); ?></th>
            <th><?= $this->Paginator->sort('voting_cards'); ?></th>
            <th><?= $this->Paginator->sort('created'); ?></th>
            <th><?= $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($voteGroups as $voteGroup): ?>
        <tr>
            <td><?= $this->Number->format($voteGroup->id) ?></td>
            <td>
                <?= $voteGroup->has('conference') ? $this->Html->link($voteGroup->conference->name, ['controller' => 'Conferences', 'action' => 'view', $voteGroup->conference->id]) : '' ?>
            </td>
            <td><?= h($voteGroup->name) ?></td>
            <td><?= $this->Number->format($voteGroup->voting_cards) ?></td>
            <td><?= h($voteGroup->created) ?></td>
            <td><?= h($voteGroup->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $voteGroup->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $voteGroup->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $voteGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $voteGroup->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
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
