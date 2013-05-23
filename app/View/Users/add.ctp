<html>
<body>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 
                               'author' => 'Author',
                               'mgr'    => 'Mgr',
                               'agm' => 'AGM',
                               'gm' => 'GM',
																'hr' => 'HR',
																'pr' => 'PR'
                               )
        ));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
</body>
</html>
