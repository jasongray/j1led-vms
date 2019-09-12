
<?php echo $this->Form->input('username', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Username'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('password', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'value' => '', 'label' => array('text' => __('Password'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('email', array('div' => 'control-group', 'class' => 'm-wrap large', 'label' => array('text' => __('Email'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php if ($this->Session->read('Auth.User.group_id') < 3) { ?>
<?php echo $this->Form->input('company_id', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Company'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
<?php } else { ?>
<?php echo $this->Form->input('company_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.company_id')));?>
<?php } ?>
<?php echo $this->Form->input('group_id', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('User Group'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
<div class="control-group">
	<label class="control-label"><?php echo __('Active?');?></label>
	<div class="controls">
		<div class="warning-toggle-button toggle-button">
			<?php echo $this->Form->input('is_active', array('div' => false, 'class' => 'toggle', 'type' => 'checkbox', 'label' => false));?>
		</div>
	</div>
</div>
<?php echo $this->Form->input('position', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Position'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('firstname', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Firstname'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('surname', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Surname'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('phone', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Phone'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('mobile', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Mobile'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
	echo $this->Html->link(__('Cancel'), array('controller' => 'users', 'action' => 'cancel'), array('class' => 'btn black'));
	if(!empty($this->data['User']['id'])){
		echo $this->Html->link(__('Delete'), array('controller' => 'users', 'action' => 'delete', $this->data['User']['id']), array('class' => 'btn red'));
	}
?>	
</div>