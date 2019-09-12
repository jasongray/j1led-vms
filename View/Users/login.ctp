	<?php echo $this->Form->create('User', array('class' => 'form-vertical login-form', 'action' => 'login'));?>
	<h3 class="form-title"><?php echo Configure::read('MySite.site_name');?></h3>
	<?php //echo $this->Session->flash('auth');?>
	<?php echo $this->Session->flash();?>
	<div class="control-group">
        <div class="controls">
        	<div class="input-icon left">
        		<i class="icon-user"></i>
        		<?php echo $this->Form->input('username', array('class' => 'm-wrap', 'placeholder' => __('Username'), 'label' => false, 'div' => false));?>
        	</div>
    	</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<?php echo $this->Form->input('password', array('class' => 'm-wrap', 'placeholder' => __('Password'), 'label' => false, 'div' => false));?>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<label class="checkbox" for="UserRemember">
        <?php echo $this->Form->input('remember', array('label' => false, 'div' => false, 'type' => 'checkbox'));?> <?php echo __('Remember Me');?></label>
        <?php echo $this->Html->link(__('Login') . ' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'users', 'action' => 'login'), array('id' => 'login-btn', 'class' => 'btn green pull-right', 'escape' => false));?>
    </div>
    <?php echo $this->Resize->image('logo.png', 300, 70, true, array('alt' => '', 'style' => 'display:block;margin:0 auto;'));?>
    <?php /* ?>
    <div class="forget-password">
    	<h4><?php echo __('Forgot your password?');?></h4>
        <p><?php echo $this->Html->link(__('Click here to reset your password'), array('controller' => 'users', 'action' => 'forgotten'), array('id' => 'forget-password'));?></p>
    </div>
	    <?php */ ?>
    <?php echo $this->Form->end();?>
    <?php //echo $this->element('forgotten-form');?>