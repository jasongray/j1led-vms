
<?php echo $this->Form->input('title', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Title'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('unique', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Alias'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<div class="control-group">
	<label class="control-label"><?php echo __('Publish');?></label>
	<div class="controls">
		<div class="warning-toggle-button toggle-button">
			<?php echo $this->Form->input('published', array('div' => false, 'class' => 'toggle', 'type' => 'checkbox', 'label' => false));?>
		</div>
	</div>
</div>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
	echo $this->Html->link(__('Cancel'), array('controller' => 'menus', 'action' => 'cancel'), array('class' => 'btn black'));
	if(!empty($this->data['Menu']['id'])){
		echo $this->Html->link(__('Delete'), array('controller' => 'menus', 'action' => 'delete', $this->data['Menu']['id']), array('class' => 'btn red'));
	}
?>	
</div>