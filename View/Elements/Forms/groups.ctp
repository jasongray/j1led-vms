<?php echo $this->Form->create('Group', array('class' => 'form-horizontal')); ?>
<?php echo $this->Form->input('name', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Group Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
	echo $this->Html->link(__('Cancel'), array('controller' => 'groups', 'action' => 'cancel'), array('class' => 'btn black'));
	if(!empty($this->data['Group']['id'])){
		echo $this->Html->link(__('Delete'), array('controller' => 'groups', 'action' => 'delete', $this->data['Group']['id']), array('class' => 'btn red'));
	}
?>	
</div>
<?php echo $this->Form->end();?>