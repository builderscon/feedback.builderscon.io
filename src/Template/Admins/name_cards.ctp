<?php foreach ($users as $user){ ?>
    <div class="name-card">
        <?= $user->conference->name ?><br />
        <?= $user->ticket_no ?><br />
        <div style="text-align:center">
        <img src="http://chart.apis.google.com/chart?cht=qr&chs=130x130&chl=http://2017.vote.iosdc.jp/vote/<?= $user->hash ?>" />
        </div>
    </div>
<?php } ?>

<?php $this->start('css'); ?>
<style>
    div.name-card { width: 240px; padding:20px; border:1px solid grey; margin:30px 30px 20px 30px; float:left; }
</style>
<?php $this->end(); ?>

