<?php echo $this->Form->create('Contract', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<?php echo $this->Form->input('sign_id', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Sign'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
<?php echo $this->Form->input('client_id', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Client'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
<?php echo $this->Form->input('title', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Contract'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
<?php echo $this->Form->input('on_hire_date', array('div' => 'control-group', 'class' => 'm-wrap m-ctrl-medium date-picker', 'label' => array('text' => __('On Hire Date'), 'class' => 'control-label'), 'between' => '<div class="controls"><div class="input-append" data-date-format="dd-mm-yyyy">', 'after' => '<span class="add-on"><i class="icon-calendar"></i></span></div></div>', 'type' => 'text')); ?>
<?php echo $this->Form->input('off_hire_date', array('div' => 'control-group', 'class' => 'm-wrap m-ctrl-medium date-picker', 'label' => array('text' => __('Off Hire Date'), 'class' => 'control-label'), 'between' => '<div class="controls"><div class="input-append" data-date-format="dd-mm-yyyy">', 'after' => '<span class="add-on"><i class="icon-calendar"></i></span></div></div>', 'type' => 'text')); ?>
<div class="form-actions">
<?php
echo $this->Form->hidden('id');
echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
echo $this->Html->link(__('Cancel'), array('controller' => 'contracts', 'action' => 'cancel'), array('class' => 'btn black'));
if(!empty($this->data['Contract']['id'])){
	echo $this->Html->link(__('Delete'), array('controller' => 'contracts', 'action' => 'delete', $this->data['Contract']['id']), array('class' => 'btn red'));
}
?>	
</div>
<?php echo $this->Form->end();?>