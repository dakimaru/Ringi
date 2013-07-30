<html>
<body>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php 
		//echo $this->Form->input('name');
		echo $this->Form->input('username');
        echo $this->Form->input('password');
		//echo $this->Form->input('department');
		
        echo $this->Form->input('usertype', array(
            'options' => array('0' => 'User', 
                               '1' => 'Admin'
                               )
        ));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
</body>
</html>
