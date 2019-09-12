<?php $this->Html->addCrumb(__('User Groups'), array('controller' => 'groups', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Edit Group'));?>
<?php echo $this->Html->css(array('bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-user"></i><?php echo __('Edit Group');?></h4>
			</div>
			<div class="portlet-body form">
				<?php echo $this->element('Forms/groups');?>
			</div>
		</div>
	</div>
</div>