<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('List Conferences'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
    <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('List Conferences'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
    <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($conference); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Conference']) ?></legend>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('slug');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
