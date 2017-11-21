<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');


$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit Vote'), ['action' => 'edit', $vote->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Vote'), ['action' => 'delete', $vote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vote->id)]) ?> </li>
<li><?= $this->Html->link(__('List Votes'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit Vote'), ['action' => 'edit', $vote->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Vote'), ['action' => 'delete', $vote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vote->id)]) ?> </li>
<li><?= $this->Html->link(__('List Votes'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Vote'), ['action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($vote->id) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Session') ?></td>
            <td><?= $vote->has('session') ? $this->Html->link($vote->session->name, ['controller' => 'Sessions', 'action' => 'view', $vote->session->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('User') ?></td>
            <td><?= $vote->has('user') ? $this->Html->link($vote->user->id, ['controller' => 'Users', 'action' => 'view', $vote->user->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($vote->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($vote->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($vote->modified) ?></td>
        </tr>
    </table>
</div>

