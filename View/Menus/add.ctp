<?php $this->Html->addCrumb(__('Menus'), array('controller' => 'menus', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Create Menu'));?>
<?php echo $this->Html->css(array('bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<?php echo $this->Form->create('Menu', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-user"></i><?php echo __('Create Menu');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/menus');?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>