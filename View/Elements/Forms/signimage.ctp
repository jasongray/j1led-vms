<?php echo $this->Form->input('name', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<div class="resizeframe">
	<?php echo $this->Html->link('<i class="icon-resize-full"></i> ' . __('Refresh Size'), '', array('class' => 'btn mini blue', 'escape' => false));?>
</div>
<?php echo $this->Form->input('width', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Width'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('height', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Height'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('company_id', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Company'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
<?php echo $this->Form->input('SignType', array('div' => 'control-group', 'class' => 'chosen span6', 'data-placeholder' => __('Select the signs for this frame'), 'multiple' => 'multiple', 'label' => array('text' => __('Sign Types'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
	echo $this->Html->link(__('Cancel'), array('controller' => 'signImages', 'action' => 'cancel'), array('class' => 'btn black'));
	if(!empty($this->data['SignImage']['id'])){
		echo $this->Html->link(__('Delete'), array('controller' => 'signImages', 'action' => 'delete', $this->data['SignImage']['id']), array('class' => 'btn red'));
	}
?>	
</div>