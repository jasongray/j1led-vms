<?php $this->Html->addCrumb(__('Contracts'), array('controller' => 'contracts', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Edit Contract'));?>
<?php echo $this->Html->css(array('datepicker', 'bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('bootstrap-datepicker-2', 'jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-user"></i><?php echo __('Edit Contract');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/contracts');?>
			</div>
		</div>
	</div>
</div>