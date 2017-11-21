<?php
/* @var $this \Cake\View\View */
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>
<?php $this->start('tb_actions'); ?>
<li>
    <?= $this->Html->link(
        __('Vote'),
        ['controller' => 'Vote', 'action' => 'index', 'user_hash' => $user->hash]
    ); ?>
</li>
<li>
    <?= $this->Html->link(
        __('Send Feedback Email'),
        ['controller' => 'Dashboard', 'action' => 'send_feedback_email', 'conference' => $conference->slug, 'hash' => $user->hash]
    ); ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>


<?php $this->start('css'); ?>
<style>
    .thumbnail {
        width:200px;
        padding:5px;
        float:left;
        margin-right:20px;
        border:1px solid #c0c0c0;
        overflow:hidden;

        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
    }
    .thumbnail img {
        width:auto;
        height:auto;
        max-width:100%;
        max-height:100%;
    }
    .thumbnail .title {
        text-align:center;
        padding-bottom:5px;
        border-bottom:1px solid #c0c0c0;
    }
    .thumbnail .button {
        text-align:center;
        padding:10px 0 5px 0;
    }

    .thumbnails:after {
        content: ".";
        display: block;
        height: 0;
        font-size: 0;
        clear: both;
        visibility:hidden;
    }
</style>
<?php $this->end(); ?>

<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Home'), ['controller' => 'Admins', 'action' => 'index']); ?></li>
    <li><?= $this->Html->link($conference->name, ['controller' => 'Dashboard', 'action' => 'index', 'conference' => $conference->slug]); ?></li>
    <li><?= $this->Html->link($user->name, ['controller' => 'Dashboard', 'action' => 'user', 'conference' => $conference->slug, $user->hash]) ?></li>
</ol>

<h2><?= $user->name ?></h2>

<div class="thumbnails">
    <div class="thumbnail">
        <div class="title"><?= __('Avatar'); ?></div>
        <div class="button">
            <?= $this->Html->link(
                __('Fetch avatar'),
                ['controller' => 'Dashboard', 'action' => 'fetchAvatar', 'conference' => $conference->slug, $user->hash],
                ['class' => ['btn', 'btn-default']]
            ); ?>
        </div>

        <?php if ($user->avatar_icon_filename){ ?>
            <?= $this->Html->image(
                '/files/'.$conference->slug.'/avatar/'.urlencode($user->avatar_icon_filename).'?'.time(),
                ['class' => ['img-circle']]
            ); ?>
        <?php } ?>
    </div>

    <div class="thumbnail">
        <div class="title"><?= __('QR'); ?></div>
        <div class="button">
            <?= $this->Html->link(
                __('Fetch QR'),
                ['controller' => 'Dashboard', 'action' => 'fetchQr', 'conference' => $conference->slug, $user->hash],
                ['class' => ['btn', 'btn-default']]
            ); ?>
        </div>

        <?php if ($user->qr_filename){ ?>
            <?= $this->Html->image('/files/'.$conference->slug.'/qr/'.urlencode($user->qr_filename).'?'.time()); ?>
        <?php } ?>
    </div>
</div>


<table class="table">
    <tr>
        <th><?= __('id'); ?></th>
        <td><?= $user->id ?></td>
    </tr>
    <tr>
        <th><?= __('mail'); ?></th>
        <td><?= $user->mail ?></td>
    </tr>
    <tr>
        <th><?= __('hash'); ?></th>
        <td><?= $user->hash ?></td>
    </tr>
    <tr>
        <th><?= __('vote_page_view'); ?></th>
        <td><?= $user->vote_page_view ?></td>
    </tr>
    <tr>
        <th><?= __('avatar_icon_filename'); ?></th>
        <td><?= $user->avatar_icon_filename ?></td>
    </tr>
    <tr>
        <th><?= __('qr_filename'); ?></th>
        <td><?= $user->qr_filename ?></td>
    </tr>
    <tr>
        <th><?= __('ticket_type'); ?></th>
        <td><?= $user->ticket_type ?></td>
    </tr>
    <tr>
        <th><?= __('ticket_no'); ?></th>
        <td><?= $user->ticket_no ?></td>
    </tr>
    <tr>
        <th><?= __('sns_accounts'); ?></th>
        <td>
            <div><?= $user->sns_accounts ?></div>
            <div>
                <?php
                if ($sns = $user->activeSns()){
                    if ($link = $user->activeSnsLink()){
                        echo $this->Html->link($sns." / ".$user->activeSnsAccount(), $link, ['target' => '_blank']);
                    } else {
                        echo $sns." / ".$user->activeSnsAccount();
                    }
                }
                ?>
            </div>
        </td>
    </tr>
</table>

<h2><?= __('Sessions this user voted for'); ?></h2>

<table class="table">
    <tr>
        <th><?= __('Voted at'); ?></th>
        <th><?= __('Title'); ?></th>
    </tr>
    <?php foreach ($user->votes as $vote){ ?>
        <tr>
            <td><?= $vote->created->i18nFormat('yyyy/MM/dd hh:mm:ss'); ?></td>
            <td><?= $vote->session->title ?></td>
        </tr>
    <?php } ?>
</table>

