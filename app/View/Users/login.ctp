<div id="login";  style="background-image:url('/Ringi/app/webroot/img/login_enspirea.jpg');background-size:100%; "class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset class="control-group">
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>

