<?= $this->start('css'); ?>
<style>
    div#welcome { font-size:large; margin-bottom:20px; }
    p.bg-info { padding:15px; margin:20px 0; }
    .button-cancel, .button-vote { width:50px; text-align:center; }
    .starts-on div { white-space: nowrap; }
    img.avatar {
        width:20px;
        border-radius:10px;
        border:1px solid #c0c0c0;
        margin-right:5px;
    }
    td.starts-on div.time {
        margin-top:5px;
    }
    div.speaker {
        margin-top:5px;
    }
</style>
<?= $this->end(); ?>
<?= $this->start('script'); ?>
<script>
    $(bind);
    function bind(){
        //alert("ok");
        $('.button-cancel').unbind('click').click(function(){
            vote($(this).attr('id'), 'cancel');
        });
        $('.button-vote').unbind('click').click(function(){
            vote($(this).attr('id'), 'post');
        });
    }
    function vote(id, action){
        var params = id.split('-');
        var userHash = params[1];
        var sessionHash = params[2];

        $('#' + id).html("<img src='/img/loading.png' />");

        var url = '/vote/' + userHash + '/' + action + '/' + sessionHash + '.json';
        //console.log(url);
        $.get(url, function(data){
            console.log(data);
            var id = '#button-' + data.user.hash + '-' + data.session.hash;
            if (data.session.voted){
                $(id).html('<?= __('Voted') ?>').removeClass('btn-default').addClass('btn-danger')
                    .removeClass('button-vote').addClass('button-cancel');
            } else {
                $(id).html('<?= __('Vote!') ?>').removeClass('btn-danger').addClass('btn-default')
                    .removeClass('button-cancel').addClass('button-vote');
            }

            if (data.votingCards - data.voted > 0){
                // Can vote more
                $('.vote-button .btn-default').show();
            } else {
                $('.vote-button .btn-default').hide();
            }

            bind();
        });
    }
</script>
<?= $this->end(); ?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand"><?= $conference->name ?> <?= __('vote'); ?></a>
        </div>
    </div>
</nav>

<div class="container">
    <div id="welcome"><?= __('Hi, {0}', $user->name); ?></div>

    <ul class="nav nav-pills">
        <?php foreach ($voteGroups as $vg){ ?>
            <li role="presentation"<?php if ($vg->id == $voteGroup->id){ ?> class="active"<?php } ?>><a href="<?= sprintf("/vote/%s/%s", $user->hash, $vg->slug); ?>"><?= $vg->name ?></a></li>
        <?php } ?>
    </ul>

    <p class="bg-info">
        <?php if ((! $conference->vote_close_at) or ($conference->vote_close_at->getTimeStamp() > time())){ ?>
            <?= __('You can vote for up to {0} talks.', $voteGroup->voting_cards); ?>
        <?php } else { ?>
            <?= __('Please submit your feedback!'); ?>
        <?php } ?>
    </p>

    <table class="table">
        <tr>
            <?php if ((! $conference->vote_close_at) or ($conference->vote_close_at->getTimeStamp() > time())){ ?>
                <th><?= __('Vote'); ?></th>
            <?php } ?>
            <th><?= __('Feedback'); ?></th>
            <th><?= __('Starts on'); ?></th>
            <th><?= __('Title'); ?></th>
        </tr>
        <?php foreach ($sessions as $session){ ?>
            <tr>
                <?php if ((! $conference->vote_close_at) or ($conference->vote_close_at->getTimeStamp() > time())){ ?>
                    <td class="vote-button">
                        <?php if (in_array($session->hash, $voteHashes)){ ?>
                            <?= $this->Form->button(
                                __('Voted'),
                                [
                                    'class' => ['btn', 'btn-danger', 'btn-xs', 'button-cancel'],
                                    'id' => 'button-'.$user->hash.'-'.$session->hash,
                                ]
                            ) ?>
                        <?php } else { ?>
                            <?php if (count($voteHashes) < $voteGroup->voting_cards){ ?>
                                <?= $this->Form->button(
                                    __('Vote!'),
                                    [
                                        'class' => ['btn', 'btn-default', 'btn-default', 'btn-xs', 'button-vote'],
                                        'id' => 'button-'.$user->hash.'-'.$session->hash,
                                    ]
                                ) ?>
                            <?php } else { ?>
                                <?= $this->Form->button(
                                    __('Vote!'),
                                    [
                                        'class' => ['btn', 'btn-default', 'btn-default', 'btn-xs', 'button-vote'],
                                        'id' => 'button-'.$user->hash.'-'.$session->hash,
                                        'style' => 'display:none;',
                                    ]
                                ) ?>
                            <?php } ?>
                        <?php } ?>
                    </td>
                <?php } ?>
                <td>
                    <?php if (in_array($session->hash, $feedbackHashes)){ ?>
                        <?= $this->Html->link(
                            __('Submitted'),
                            ['controller' => 'Vote', 'action' => 'feedback', 'user_hash' => $user->hash, 'session_hash' => $session->hash],
                            ['class' => ['btn', 'btn-danger', 'btn-xs']]
                        ) ?>
                    <?php } else { ?>
                        <?= $this->Html->link(
                            __('Feedback'),
                            ['controller' => 'Vote', 'action' => 'feedback', 'user_hash' => $user->hash, 'session_hash' => $session->hash],
                            ['class' => ['btn', 'btn-default', 'btn-xs']]
                        ) ?>
                    <?php } ?>
                </td>
                <td class="starts-on">
                    <div class="track"><?= $session->track->name ?></div>
                    <div class="time"><?= $session->start_at->i18nFormat('MM/dd HH:mm') ?></div>
                </td>
                <td>
                    <div><?= $session->title ?></div>
                    <div class="speaker">
                        <?php
                        if (isset($session->speaker->user->avatar_icon_filename) and $session->speaker->user->avatar_icon_filename){
                            echo $this->Html->image(
                                '/files/'.$conference->slug.'/avatar/'.urlencode($session->speaker->user->avatar_icon_filename),
                                ['class' => 'avatar']
                            );
                        }
                        ?>
                        <?= $session->speaker->name ?>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>

