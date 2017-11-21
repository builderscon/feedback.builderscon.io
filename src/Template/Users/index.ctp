<?php
/* @var $this \Cake\View\View */
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('New User'), ['action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']); ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id'); ?></th>
            <th><?= $this->Paginator->sort('email'); ?></th>
            <th><?= $this->Paginator->sort('password'); ?></th>
            <th><?= $this->Paginator->sort('conference_id'); ?></th>
            <th><?= $this->Paginator->sort('hash'); ?></th>
            <th><?= $this->Paginator->sort('created'); ?></th>
            <th><?= $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $this->Number->format($user->id) ?></td>
            <td><?= h($user->email) ?></td>
            <td><?= h($user->password) ?></td>
            <td>
                <?= $user->has('conference') ? $this->Html->link($user->conference->name, ['controller' => 'Conferences', 'action' => 'view', $user->conference->id]) : '' ?>
            </td>
            <td><?= h($user->hash) ?></td>
            <td><?= h($user->created) ?></td>
            <td><?= h($user->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $user->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $user->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
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
