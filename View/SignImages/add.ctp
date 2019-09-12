<?php $title_for_layout = __('Add Image');?>
<?php $this->Html->addCrumb(__('Image Library'), array('controller' => 'signImages', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Add Image'));?>
<?php echo $this->Html->css(array('bootstrap-chosen', 'bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('chosen.jquery.min', 'jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<?php echo $this->Form->create('SignImage', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-legal"></i><?php echo __('Sign Information');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/signimage');?>
			</div>
		</div>
	</div>
	<div class="span8 previewwrapper">
		<div class="portlet box yellow">
			<div class="portlet-title">
				<h4><i class="icon-pencil"></i><?php echo __('Designer');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/signimage-designer');?>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-picture"></i><?php echo __('Import BMP');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/signimage-image');?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>