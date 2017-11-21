<?php $this->extend('../Layout/TwitterBootstrap/signin'); ?>
<?php $this->start('css'); ?>
<style>
.form-signin input#inputUsername {
    margin-bottom: -2px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    width:100%;
}
.form-signin input#inputPassword {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    width:100%;
}
</style>
<?php $this->end(); ?>


<?= $this->Form->create($user, ['class' => 'form-signin']); ?>
<h2 class="form-signin-heading">Login</h2>

<?= $this->Flash->render() ?>

<?= $this->Form->text('username', ['id' => 'inputUsername', 'class' => 'form-control', 'placeholder' => 'Username', 'required', 'autofocus']); ?>
<?= $this->Form->password('password', ['id' => 'inputPassword', 'class' => 'form-control', 'placeholder' => 'Password', 'required']); ?>
<?= $this->Form->submit(__('Login'), ['class' => ['btn btn-lg btn-primary btn-block']]); ?>
<?= $this->form->end(); ?>
