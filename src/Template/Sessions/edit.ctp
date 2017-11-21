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
        ['action' => 'delete', $session->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $session->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Sessions'), ['action' => 'index']) ?></li>
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
    <li><?=
    $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $session->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $session->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Sessions'), ['action' => 'index']) ?></li>
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
<?= $this->Form->create($session); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Session']) ?></legend>
    <?php
    echo $this->Form->control('conference_id', ['options' => $conferences]);
    echo $this->Form->control('speaker_id', ['options' => $speakers]);
    echo $this->Form->control('vote_group_id', ['options' => $voteGroups]);
    echo $this->Form->control('hash');
    echo $this->Form->control('name');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
