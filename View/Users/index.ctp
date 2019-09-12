<?php $this->Html->addCrumb(__('Users'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-user"></i><?php echo __('Users');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add User'), array('controller' => 'users', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('username', __('Username'));?></th>
							<th class="hidden-phone"><?php echo __('Name');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('group_id', __('Group'));?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('client_id', __('Company'));?></th>
							<th class="hidden-phone"><?php echo __('Email');?></th>
							<th><?php echo $this->Paginator->sort('last_login', __('Last Login'));?></th>
							<th colspan="2" class="hidden-phone" style="width:170px;"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($users) { ?>
						<?php foreach ($users as $u) { ?>
							<tr>
								<td><?php echo $this->Html->link($u['User']['username'], array('controller' => 'users', 'action' => 'edit', $u['User']['id']));?></td>
								<td class="hidden-phone"><?php echo $u['User']['firstname'];?> <?php echo $u['User']['surname'];?></td>
								<td class="hidden-phone"><?php echo $u['Group']['name'];?></td>
								<td class="hidden-phone"><?php echo $u['Company']['name'];?></td>
								<td class="hidden-phone"><?php echo $u['User']['email'];?></td>
								<td><?php if (!empty($u['User']['last_login'])){ echo $this->Time->timeAgoInWords($u['User']['last_login'], array('end' => '+1 year')); } else { echo __('Never'); } ?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'users', 'action' => 'edit', $u['User']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'users', 'action' => 'delete', $u['User']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
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