<html>
<body>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('role', array(
            'options' => array(
                               	'author' => 'Author',
                               	'mgr'    => 'MGR',
                               	'agm' => 'AGM',
                               	'gm' => 'GM',
																'hr' => 'HR',
																'pr' => 'PR',
																'admin' => 'Admin',
                               )
        ));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
</body>
</html>
