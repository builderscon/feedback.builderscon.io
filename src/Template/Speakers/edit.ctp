<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?=
    $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $speaker->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $speaker->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Speakers'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?=
    $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $speaker->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $speaker->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Speakers'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($speaker); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Speaker']) ?></legend>
    <?php
    echo $this->Form->control('name');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
