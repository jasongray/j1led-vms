<?php $this->Html->addCrumb(__('Notifications'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-notification"></i><?php echo __('Notifications');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php if ($editable) { ?>
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add Notification'), array('controller' => 'notifications', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
					<?php } ?>
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th colspan="3" ><?php echo __('Notification');?></th>
							<th><?php echo $this->Paginator->sort('created', __('Created'));?></th>
							<?php if ($editable) { ?>
							<th colspan="2" class="hidden-phone" style="width:170px;"><?php echo __('Actions');?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php if ($notifications) { ?>
						<?php foreach ($notifications as $n) { ?>
							<?php switch ($n['Notification']['type']) { 
			            		case 'success': 
			            		$str = '<span class="label label-success"><i class="icon-plus"></i></span> '; 
			            		break; 
			            		case 'important' : default: 
			            		$str = '<span class="label label-important"><i class="icon-bolt"></i></span> '; 
			            		break; 
			            		case 'warning': 
			            		$str = '<span class="label label-warning"><i class="icon-bell"></i></span> '; 
			            		break; 
			            		case 'info': 
			            		$str = '<span class="label label-info"><i class="icon-bullhorn"></i></span> '; 
			            		break;  
			            	} ?>
							<tr>
								<td><?php if ($n['Notification']['read'] == 0) { echo '<i class="icon-envelope-alt"></i>'; } else { echo '<i class="icon-envelope"></i>'; } ?></td>
								<td><?php echo $str;?></td>
								<?php if ($editable) { ?>
								<td><?php echo $this->Html->link($n['Notification']['summary'], array('controller' => 'notifications', 'action' => 'edit', $n['Notification']['id']));?></td>
								<?php } else { ?>
								<td><?php echo $this->Html->link($n['Notification']['summary'], array('controller' => 'notifications', 'action' => 'view', $n['Notification']['id']));?></td>
								<?php } ?>
								<td><?php echo $this->Time->timeAgoInWords($n['Notification']['created'], array('end' => '+1 year')); ?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'notifications', 'action' => 'edit', $n['Notification']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'notifications', 'action' => 'delete', $n['Notification']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
				<?php echo $this->element('pagination');?>
			</div>
		</div>
	</div>
</div>