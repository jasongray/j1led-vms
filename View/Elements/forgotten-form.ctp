	<?php echo $this->Form->create('User', array('class' => 'form-vertical forget-form', 'url' => '/users/forgotten'));?>
		<h3 class=""><?php echo __('Forget Password ?');?></h3>
		<p><?php echo __('Enter your e-mail address below to reset your password.');?></p>
		<div class="control-group">
			<div class="controls">
				<div class="input-icon left">
					<i class="icon-envelope"></i>
					<?php echo $this->Form->input('email', array('class' => 'm-wrap', 'placeholder' => 'Email', 'div' => false, 'label' => false));?>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<?php echo $this->Html->link(__('Back') . ' <i class="m-icon-swapleft"></i>', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn', 'escape' => false));?>
			<?php echo $this->Html->link(__('Reset') . ' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'users', 'action' => 'forgotten'), array('id' => 'forget-btn', 'class' => 'btn green pull-right', 'escape' => false));?>
		</div>
	<?php echo $this->Form->end();?>