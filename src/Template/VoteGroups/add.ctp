<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('List Vote Groups'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
    <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('List Vote Groups'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Conferences'), ['controller' => 'Conferences', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Conference'), ['controller' => 'Conferences', 'action' => 'add']) ?> </li>
    <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($voteGroup); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Vote Group']) ?></legend>
    <?php
    echo $this->Form->control('conference_id', ['options' => $conferences]);
    echo $this->Form->control('name');
    echo $this->Form->control('voting_cards');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
