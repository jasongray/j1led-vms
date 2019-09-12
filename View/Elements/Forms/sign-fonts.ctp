<?php echo $this->Form->create('SignFont', array('class' => 'form-horizontal')); ?>
<?php echo $this->Form->input('title', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Font Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('rta_code', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('RTA Code'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
	echo $this->Html->link(__('Cancel'), array('controller' => 'signFonts', 'action' => 'cancel'), array('class' => 'btn black'));
	if(!empty($this->data['SignFont']['id'])){
		echo $this->Html->link(__('Delete'), array('controller' => 'signFonts', 'action' => 'delete', $this->data['SignFont']['id']), array('class' => 'btn red'));
	}
?>	
</div>
<?php echo $this->Form->end();?>