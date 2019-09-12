<?php $title_for_layout = __('Edit Sign Type');?>
<?php $this->Html->addCrumb(__('Sign Types'), array('controller' => 'signTypes', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Edit Sign Type'));?>
<?php echo $this->Html->css(array('bootstrap-chosen', 'bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('chosen.jquery.min', 'jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<?php echo $this->Form->create('SignType', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="row-fluid">
	<div class="span8">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-legal"></i><?php echo __('Sign Information');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/signtypes');?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-picture"></i><?php echo __('Image');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/signtype-image');?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>