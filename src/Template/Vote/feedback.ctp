<?= $this->start('css'); ?>
<style>
    h1 {
        font-size:16pt;
    }
    img.avatar {
        width:40px;
        border-radius:20px;
        border:1px solid #c0c0c0;
        margin-right:10px;
    }
    div.feedback-body {
        padding:0 20px 40px 20px;
    }
    div.speaker {
        margin:20px 0;
    }
    div.speaker span.speaker-name {
        font-size:14pt;
    }
    div.radios {
        margin-top:10px;
    }
    div.radios label {
        margin-right:10px;
    }
    div.radios input {
        margin-right:5px;
    }
    ol.breadcrumb {
        margin:0 20px;
    }
    div.flash {
        margin:20px;
    }
</style>
<?= $this->end(); ?>

<?= $this->start('tb_body_start'); ?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand"><?= $conference->name ?> <?= __('vote'); ?></a>
        </div>
    </div>
</nav>

<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Home'), ['controller' => 'Vote', 'action' => 'index', 'user_hash' => $user->hash]); ?></li>
    <li><?= $session->title ?></li>
</ol>

<?php if (isset($this->Flash)){ ?>
    <div class="flash">
        <?= $this->Flash->render(); ?>
    </div>
<?php } ?>


<?= $this->end(); ?>

<div class="feedback-body">

    <h1><?= __('Feedback to {0}', $session->title) ?></h1>

    <div class="speaker">
        <?php
        if (isset($session->speaker->user->avatar_icon_filename) and $session->speaker->user->avatar_icon_filename){
            echo $this->Html->image(
                '/files/'.$conference->slug.'/avatar/'.urlencode($session->speaker->user->avatar_icon_filename),
                ['class' => 'avatar']
            );
        }
        ?>
        <span class="speaker-name">
        <?= $session->speaker->name ?>
    </span>
    </div>


    <?= $this->Form->create($feedbackForm); ?>
    <?php
    $this->Form->templates([
        'nestingLabel' => '{{hidden}}<label class="btn btn-default">{{input}}{{text}}</label>',
    ]);
    ?>

    <?php /** @var \App\Model\Entity\Question $question */ ?>
    <?php foreach($questions as $question){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="question">
                    <span class="question-no">Q<?= $question->question_no ?>.</span>
                    <span class="question-question"><?= $question->question ?></span>
                </div>
            </div>
            <div class="panel-body">
                <?php $fieldName = sprintf("q%d", $question->question_no); ?>
                <?php if ($question->question_type == 1){ ?>
                    <?= $this->Form->textarea($fieldName); ?>
                <?php } ?>
                <?php if ($question->question_type == 2){ ?>
                    <?php $options = json_decode($question->option_json); ?>
                    <div>
                        <?= $options->label->left ?> 1 ... <?= $options->levels ?> <?= $options->label->right ?>
                    </div>
                    <div class="radios">
                        <?= $this->Form->radio($fieldName, range(1, $options->levels)); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php } ?>

    <?= $this->Form->submit(__('Submit')); ?>

    <?= $this->Form->end(); ?>
</div>


