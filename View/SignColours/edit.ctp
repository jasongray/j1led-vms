<?php $this->Html->addCrumb(__('Sign Colours'), array('controller' => 'signColours', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Edit Colour'));?>
<?php echo $this->Html->css(array('bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-user"></i><?php echo __('Edit Colour');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/sign-colours');?>
			</div>
		</div>
	</div>
</div>