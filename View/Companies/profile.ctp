<?php $this->Html->addCrumb(__('Companies'), array('controller' => 'companies', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('My Company'));?>
<?php echo $this->Html->css(array('bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<?php echo $this->Form->create('Company', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="row-fluid">
	<div class="span8">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-legal"></i><?php echo __('Company Information');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/companies');?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-picture"></i><?php echo __('Company Logo & CSS');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/companies-avatar');?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>