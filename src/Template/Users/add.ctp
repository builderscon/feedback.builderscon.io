<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
    <li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
    <li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($user); ?>
<fieldset>
    <legend><?= __('Add {0}', ['User']) ?></legend>
    <?php
    echo $this->Form->control('email');
    echo $this->Form->control('password');
    echo $this->Form->control('conference_id', ['options' => $conferences]);
    echo $this->Form->control('hash');
    echo $this->Form->control('ticket_no');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
