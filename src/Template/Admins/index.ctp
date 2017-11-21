<?php $this->start('css'); ?>
<style>
    .conference-btn { margin-right:20px; }
</style>
<?php $this->end(); ?>

<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php /*
<ul>
    <li><?= $this->Html->link(__('Import Peatix CSV'), ['controller' => 'ImportPeatix', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Output name cards'), ['controller' => 'Admins', 'action' => 'nameCards']); ?></li>
</ul>
*/ ?>

<?php foreach ($conferences as $conference){ ?>
<?= $this->Html->link($conference->name, ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug], ['class' => ['conference-btn', 'btn', 'btn-default', 'btn-lg']]); ?>
<?php } ?>

<?php $this->start('tb_sidebar'); ?>
<h3>データ管理</h3>

<ul>
    <li><?= $this->Html->link('Conferences', ['controller' => 'Conferences', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link('Sessions', ['controller' => 'Sessions', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link('Speakers', ['controller' => 'Speakers', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link('Vote Groups', ['controller' => 'VoteGroups', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link('Votes', ['controller' => 'Votes', 'action' => 'index']); ?></li>
</ul>

<?php /*
<h3>ユーザ一覧</h3>

<div>
選択したユーザで投票します。
</div>

<ul>
    <?php foreach ($users as $user){ ?>
        <li><?= $this->Html->link($user->ticket_no, sprintf('/vote/%s', $user->hash)); ?></li>
    <?php } ?>
</ul>
*/ ?>
<?php $this->end(); ?>
